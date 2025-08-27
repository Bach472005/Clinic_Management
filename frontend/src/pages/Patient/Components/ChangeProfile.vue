<template>
  <h2 class="text-2xl font-semibold mb-6">Thông tin cá nhân <div class="uppercase">{{ role }}</div></h2>
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
    <div class="mb-4 col-span-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Họ tên</label>
      <input type="text" v-model="form.name" class="input w-full" />
      <span v-if="errors.name" class="text-red-500 text-sm">
        {{ Array.isArray(errors.name) ? errors.name[0] : errors.name }}
      </span>
    </div>

    <!-- Nick Name -->
    <div class="mb-4 col-span-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Nick name</label>
      <input type="text" v-model="form.nickname" class="input w-full" />
      <span v-if="errors.nickname" class="text-red-500 text-sm">
        {{ Array.isArray(errors.nickname) ? errors.name[nickname] : errors.nickname }}
      </span>
    </div>

    <!-- DOB -->
    <div class="mb-4 col-span-4">
      <label for="dob" class="block text-sm font-medium text-gray-700 mb-1"
        >Ngày tháng năm sinh</label
      >
      <input
        v-model="form.dob"
        type="date"
        id="dob"
        class="p-2 border rounded-md w-full"
        required
      />
    </div>

    <!-- GENDER -->
    <div class="mb-4 col-span-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Giới tính</label>
      <select v-model="form.gender" class="p-2 border rounded-md w-full" required>
        <option disabled value="">Gender</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
        <option value="other">Other</option>
      </select>
    </div>

    <!-- Email -->
    <div class="mb-4 col-span-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
      <p class="input w-full">
        {{ form.email }}
      </p>
    </div>

    <!-- Phone -->
    <div class="mb-4 col-span-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
      <input type="text" v-model="form.phone" maxlength="11" class="input w-full" />
      <span v-if="errors.phone" class="text-red-500 text-sm">
        {{ Array.isArray(errors.phone) ? errors.phone[0] : errors.phone }}
      </span>
    </div>

    <!-- Address -->
    <div class="mb-4 col-span-12">
      <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
      <input
        v-model="form.address"
        type="text"
        id="address"
        placeholder="Address"
        class="p-2 border rounded-md w-full"
        required
      />
    </div>

    <!-- Occupation -->
    <div class="mb-4 col-span-12">
      <label for="occupation" class="block text-sm font-medium text-gray-700 mb-1"
        >Occupation</label
      >
      <input
        v-model="form.occupation"
        type="text"
        id="occupation"
        placeholder="Occupation"
        class="p-2 border rounded-md w-full"
        required
      />
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
import { useProfile } from '@/composables/useProfile'
const {
  form,
  errors,
  loading,
  loadingProfile,
  role,
  completedFields,
  progressPercentage,
  totalFields,
  submitProfile,
} = useProfile()

const handleSubmit = async () => {
  await submitProfile()
}
</script>
