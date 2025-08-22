<template>
  <h2 class="text-2xl font-semibold mb-6">Thông tin cá nhân</h2>
  <!-- Thanh tiến trình -->
  <div class="mb-4">
    <p class="text-sm text-gray-600 mb-2">Hoàn thành profile: {{ progressPercentage }}%</p>
    <div class="relative pt-1">
      <div class="flex mb-2 items-center justify-between">
        <div>
          <span
            class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-teal-600 bg-teal-200"
          >
            {{ completedFields }} / {{ totalFields }} trường đã điền
          </span>
        </div>
      </div>
      <div class="flex mb-2">
        <div class="w-full bg-gray-200 rounded-full">
          <div
            class="bg-blue-500 text-xs leading-none py-1 text-center text-white rounded-full"
            :style="'width: ' + progressPercentage + '%'"
          ></div>
        </div>
      </div>
    </div>
  </div>
  <div v-if="loadingProfile">
    <p>Đang tải dữ liệu...</p>
    <!-- hoặc spinner -->
  </div>
  <form v-else @submit.prevent="handleSubmit" class="grid grid-cols-12 gap-4">
    <!-- Name -->
    <div class="mb-4 col-span-6">
      <label class="block text-sm font-medium text-gray-700 mb-1">Họ tên</label>
      <input type="text" v-model="form.name" class="input w-full" />
      <span v-if="errors.name" class="text-red-500 text-sm">
        {{ Array.isArray(errors.name) ? errors.name[0] : errors.name }}
      </span>
    </div>

    <!-- DOB -->
    <div class="mb-4 col-span-6">
      <label for="dob" class="block text-sm font-medium text-gray-700 mb-1"
        >Ngày tháng năm sinh</label
      >
      <input
        v-model="form.dob"
        type="date"
        id="dob"
        class="mt-1 p-2 border rounded-md w-full"
        required
      />
    </div>

    <!-- GENDER -->
    <div class="mb-4 col-span-6">
      <label class="block text-sm font-medium text-gray-700 mb-1">Giới tính</label>
      <select v-model="form.gender" class="mt-1 p-2 border rounded-md w-full" required>
        <option disabled value="">Gender</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
        <option value="other">Other</option>
      </select>
    </div>

    <!-- Email -->
    <div class="mb-4 col-span-6">
      <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
      <p class="input w-full">
        {{ form.email }}
      </p>
    </div>

    <!-- Phone -->
    <div class="mb-4 col-span-6">
      <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
      <input type="text" v-model="form.phone" maxlength="11" class="input w-full" />
      <span v-if="errors.phone" class="text-red-500 text-sm">
        {{ Array.isArray(errors.phone) ? errors.phone[0] : errors.phone }}
      </span>
    </div>

    <!-- Address -->
    <div class="mb-4 col-span-6">
      <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
      <input
        v-model="form.address"
        type="text"
        id="address"
        placeholder="Address"
        class="mt-1 p-2 border rounded-md w-full"
        required
      />
    </div>

    <!-- Occupation -->
    <div class="mb-4 col-span-6">
      <label for="occupation" class="block text-sm font-medium text-gray-700 mb-1"
        >Occupation</label
      >
      <input
        v-model="form.occupation"
        type="text"
        id="occupation"
        placeholder="Occupation"
        class="mt-1 p-2 border rounded-md w-full"
        required
      />
    </div>
    <!-- Role -->
    <div class="mb-4 col-span-6">
      <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
      <p class="input w-full uppercase">
        {{ form.role }}
      </p>
    </div>

    <!-- Buttons -->
    <div class="col-span-12">
      <button
        type="submit"
        class="w-full bg-blue-600 text-white px-4 py-2 rounded cursor-pointer hover:bg-blue-700 disabled:opacity-50"
        :disabled="loading"
      >
        <span v-if="loading">Loading...</span>
        <span v-else>Save</span>
      </button>
    </div>
  </form>
</template>

<script setup>
import { changeProfile, profile } from '@/services/profile'
import { computed, onMounted, ref } from 'vue'

const loadingProfile = ref(true)
const user = ref(null)
const form = ref({
  email: '',
  name: '',
  phone: '',
  dob: '',
  gender: '',
  address: '',
  occupation: '',
  role: '',
})

onMounted(async () => {
  try {
    user.value = await profile()

    form.value = {
      email: user.value.email,
      name: user.value.name,
      phone: user.value.phone,
      dob: user.value.patient.dob,
      gender: user.value.patient.gender ?? '',
      address: user.value.patient.address,
      occupation: user.value.patient.occupation,
      role: user.value.role.name,
    }
    console.log(user);
    
  } catch (error) {
    console.error('Error loading user profile:', error)
  } finally {
    loadingProfile.value = false
  }
})
const loading = ref(false)
const errors = ref({
  name: null,
  phone: null,
})

const handleSubmit = async () => {
  errors.value = {
    name: null,
    phone: null,
  }
  loading.value = true
  const changeProfileErrors = await changeProfile(
    {
      name: form.value.name,
      phone: form.value.phone,
    },
    (isLoading) => {
      loading.value = isLoading
    },
  )
  if (changeProfileErrors) {
    errors.value = changeProfileErrors
  }
}

const totalFields = 8 // Tính tổng các trường cần điền

// Hàm tính số trường đã điền
const completedFields = computed(() => {
  return Object.values(form.value).filter((value) => value !== '' && value !== null).length
})

// Tính tỷ lệ phần trăm hoàn thành
const progressPercentage = computed(() => {
  return Math.floor((completedFields.value / totalFields) * 100)
})
</script>
