import { ref, computed, onMounted } from 'vue'
import { changeProfile, getCompletedFields, getProgressPercentage } from '@/services/profile'

export function useProfile() {
  const loadingProfile = ref(true)
  const loading = ref(false)
  const user = ref(null)
  const role = ref('')
  const errors = ref({})

  const form = ref({
    email: '',
    name: '',
    nickname: '',
    phone: '',
    dob: '',
    gender: '',
    address: '',
    occupation: '',
  })

  const totalFields = 7

  const completedFields = computed(() => getCompletedFields(form.value))
  const progressPercentage = computed(() =>
    getProgressPercentage(completedFields.value, totalFields)
  )

  // Load dữ liệu từ sessionStorage hoặc API
  const loadProfile = async () => {
    loadingProfile.value = true
    try {
      const cachedProfile = sessionStorage.getItem('user')
      if (cachedProfile) {
        const parsed = JSON.parse(cachedProfile)
        user.value = parsed
        
        role.value = parsed.role.name
        form.value = {
          email: parsed.email,
          name: parsed.name,
          nickname: parsed.patient?.nickname ?? '',
          phone: parsed.phone,
          dob: parsed.patient?.dob ?? '',
          gender: parsed.patient?.gender ?? '',
          address: parsed.patient?.address ?? '',
          occupation: parsed.patient?.occupation ?? '',
        }
        
      } else {
        // Nếu bạn muốn gọi API khi không có cache, có thể bổ sung ở đây
        const fetched = await profile()
        user.value = fetched
        role.value = fetched.role.name
        form.value = {
          email: fetched.email,
          name: fetched.name,
          nickname: fetched.patient.nickname,
          phone: fetched.phone,
          dob: fetched.patient.dob,
          gender: fetched.patient.gender ?? '',
          address: fetched.patient.address,
          occupation: fetched.patient.occupation,
        }
        sessionStorage.setItem('user', JSON.stringify(fetched))
      }
    } catch (error) {
      console.error('Error loading user profile:', error)
    } finally {
      loadingProfile.value = false
    }
  }

  // Hàm submit form
  const submitProfile = async () => {
    errors.value = {}
    loading.value = true

    const changeProfileErrors = await changeProfile(
      {
        email: form.value.email,
        name: form.value.name,
        nickname: form.value.nickname,
        phone: form.value.phone,
        dob: form.value.dob,
        gender: form.value.gender,
        address: form.value.address,
        occupation: form.value.occupation,
      },
      (isLoading) => {
        loading.value = isLoading
      }
    )

    if (changeProfileErrors) {
      errors.value = changeProfileErrors
    }

    loading.value = false
    return changeProfileErrors
  }

  onMounted(loadProfile)

  return {
    form,
    errors,
    loading,
    loadingProfile,
    role,
    completedFields,
    progressPercentage,
    totalFields,
    submitProfile,
  }
}
