<template>
  <div class="flex flex-col md:flex-row gap-6 p-6 bg-gray-50 min-h-screen" v-if="psychologist">
    <!-- LEFT: Therapist Info (33%) -->
    <div
      class="w-full md:w-1/3 bg-white rounded-xl shadow-lg p-6 flex flex-col gap-4 border border-gray-100"
    >
      <!-- Avatar + Basic Info -->
      <div class="flex flex-col items-center text-center">
        <img
          class="w-28 h-28 rounded-full object-cover border-4 border-indigo-100"
          :src="psychologist.image || 'https://via.placeholder.com/150'"
          alt="Therapist Photo"
        />
        <h2 class="mt-4 text-2xl font-semibold text-gray-800">{{ psychologist.name }}</h2>
        <p class="text-indigo-600 font-medium">{{ psychologist.specialization }}</p>
        <p class="text-sm text-gray-500 italic" v-if="psychologist.tagline">
          “{{ psychologist.tagline }}”
        </p>
      </div>

      <hr class="my-2 border-gray-200" />

      <div class="text-sm text-gray-700 space-y-2">
        <div class="flex items-start gap-2" v-if="psychologist.education">
          <span class="text-indigo-500"><i class="fa-solid fa-graduation-cap"></i></span>
          <span><strong>Học vấn:</strong> {{ psychologist.education }}</span>
        </div>
        <div class="flex items-start gap-2" v-if="psychologist.experience !== undefined">
          <span class="text-indigo-500"><i class="fa-solid fa-briefcase"></i></span>
          <span><strong>Kinh nghiệm:</strong> {{ psychologist.experience }} năm</span>
        </div>
        <div class="flex items-start gap-2" v-if="psychologist.method">
          <span class="text-indigo-500"><i class="fa-solid fa-brain"></i></span>
          <span><strong>Phương pháp:</strong> {{ psychologist.method }}</span>
        </div>
        <div class="flex items-start gap-2" v-if="psychologist.focusAreas">
          <span class="text-indigo-500"><i class="fa-solid fa-heart"></i></span>
          <span><strong>Chuyên sâu:</strong> {{ psychologist.focusAreas }}</span>
        </div>
      </div>

      <div class="mt-2 text-sm text-gray-600 leading-relaxed" v-if="psychologist.bio">
        {{ psychologist.bio }}
      </div>

      <div class="mt-4 flex flex-col gap-2">
        <button class="bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700 text-sm">
          Đặt buổi trò chuyện đầu tiên
        </button>
        <button
          class="text-indigo-600 border border-indigo-600 py-1.5 px-4 rounded hover:bg-indigo-50 text-sm"
        >
          Tìm hiểu thêm về chuyên gia
        </button>
      </div>
    </div>

    <!-- RIGHT: Booking Form (67%) -->
    <div class="w-full md:w-2/3 bg-white rounded-lg shadow p-6">
      <h2 class="text-xl font-semibold mb-4">Đặt buổi trị liệu</h2>
      <form @submit.prevent="submitForm" class="space-y-4">
        <div>
          <label class="block mb-1 font-medium">Chọn ngày</label>
          <select v-model="form.date" class="w-full border rounded px-3 py-2" required>
            <option disabled value="">-- Chọn ngày --</option>
            <option v-for="day in next7Days" :key="day.iso" :value="day.iso">
              {{ day.display }}
            </option>
          </select>
        </div>

        <div>
          <label class="block mb-1 font-medium">Chọn giờ</label>
          <select v-model="form.time" class="w-full border rounded px-3 py-2" required>
            <option disabled value="">-- Chọn giờ --</option>
            <option v-for="slot in filteredTimes" :key="slot" :value="slot">{{ slot }}</option>
          </select>
        </div>

        <div>
          <label class="block mb-1 font-medium">Hình thức trị liệu</label>
          <select v-model="form.mode" class="w-full border rounded px-3 py-2" required>
            <option value="offline">Gặp trực tiếp</option>
            <option value="online">Online qua Zoom/Google Meet</option>
          </select>
        </div>

        <div>
          <label class="block mb-1 font-medium">Lý do bạn muốn trị liệu?</label>
          <textarea
            v-model="form.reason"
            rows="3"
            class="w-full border rounded px-3 py-2"
            placeholder="Bạn có thể chia sẻ ngắn gọn điều bạn đang trải qua..."
          ></textarea>
        </div>

        <button
          type="submit"
          class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700"
        >
          Đặt lịch trị liệu
        </button>
      </form>
    </div>
  </div>

  <div v-else class="flex justify-center items-center h-screen text-gray-600">
    Đang tải dữ liệu chuyên gia...
  </div>
</template>

<script setup>
import { onMounted, reactive, ref, computed } from 'vue'
import { psychologistSchedule, bookAppointment } from '@/services/schedule'
import { useRoute } from 'vue-router'
import { useToast } from 'vue-toastification' 

const route = useRoute()
const psychologistID = route.params.id
const toast = useToast()
const psychologist = ref(null)
const schedule = ref([])

function getPatientFromSession() {
  const patientStr = sessionStorage.getItem('user')
  if (!patientStr) return null
  try {
    return JSON.parse(patientStr)
  } catch (error) {
    console.error('Lỗi parse JSON:', error)
    return null
  }
}

const patient = ref(getPatientFromSession())

const daysOfWeek = ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy']

function formatDateDisplay(date) {
  const d = new Date(date)
  return `${daysOfWeek[d.getDay()]}, ${String(d.getDate()).padStart(2, '0')}/${String(d.getMonth() + 1).padStart(2, '0')}/${d.getFullYear()}`
}

function getNext7Days() {
  const today = new Date()
  return Array.from({ length: 7 }).map((_, i) => {
    const date = new Date(today)
    date.setDate(today.getDate() + i)
    const iso = date.toISOString().split('T')[0]
    return { iso, display: formatDateDisplay(iso) }
  })
}

const next7Days = computed(() => getNext7Days())

async function loadSchedule() {
  const response = await psychologistSchedule(psychologistID)
  psychologist.value = response.psychologist
  schedule.value = response.schedule
}

onMounted(loadSchedule)

const form = reactive({
  date: '',
  time: '',
  mode: 'offline',
  reason: '',
})

const filteredTimes = computed(() => {
  if (!form.date) return []
  const slots = schedule.value
    .filter(s => s.available_date === form.date)
    .map(s => s.start_time.slice(0, 5))
  return [...new Set(slots)]
})

const submitForm = async () => {
  if (!patient.value?.patient?.id) {
    toast.error('Bạn cần đăng nhập để đặt lịch')
    return
  }

  const selectedSchedule = schedule.value.find(
    s => s.available_date === form.date && s.start_time.startsWith(form.time)
  )

  if (!selectedSchedule) {
    toast.error('Không tìm thấy lịch phù hợp. Vui lòng chọn lại ngày và giờ.')
    return
  }

  const payload = {
    schedule_id: selectedSchedule.id,
    method: form.mode,
    notes: form.reason,
    patient_id: patient.value.patient.id,
  }

  try {
    await bookAppointment(payload)
    toast.success('Đặt lịch thành công!')

    Object.assign(form, { date: '', time: '', reason: ''})
  } catch (err) {
    if (err.response?.status === 409) {
      toast.error('Lịch đã được đặt bởi người khác. Vui lòng chọn lịch khác.')
    } else {
      toast.error('Đặt lịch thất bại. Vui lòng thử lại.')
    }
  }
}
</script>
