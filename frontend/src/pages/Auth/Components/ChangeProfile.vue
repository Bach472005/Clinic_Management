<template>
  <h2 class="text-2xl font-semibold mb-6">Thông tin cá nhân</h2>

  <form @submit.prevent="handleSubmit" class="grid grid-cols-12 gap-4">
    <!-- Name -->
    <div class="mb-4 col-span-6">
      <label class="block text-sm font-medium text-gray-700 mb-1">Họ tên</label>
      <input type="text" v-model="form.name" class="input w-full" />
      <span v-if="errors.name" class="text-red-500 text-sm">
        {{
          Array.isArray(errors.name)
            ? errors.name[0]
            : errors.name
        }}
      </span>
    </div>

    <!-- Email -->
    <div class="mb-4 col-span-6">
      <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
      <p class="input w-full">
        {{ user.email }}
      </p>
    </div>
    <!-- Phone -->
    <div class="mb-4 col-span-6">
      <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
      <input type="text" v-model="form.phone" maxlength="11" class="input w-full" />
      <span v-if="errors.phone" class="text-red-500 text-sm">
        {{
          Array.isArray(errors.phone)
            ? errors.phone[0]
            : errors.phone
        }}
      </span>
    </div>

    <div class="mb-4 col-span-6">
      <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
      <p class="input w-full">
        {{ user.role.name }}
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
import { changeProfile } from '@/services/auth'
import { ref } from 'vue'

const user = JSON.parse(sessionStorage.getItem('user'))
// Form state
const form = ref({
  name: user.name,
  phone: user.phone,
})

const errors = ref({
  name: null,
  phone: null,
})
const loading = ref(false)

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
</script>
