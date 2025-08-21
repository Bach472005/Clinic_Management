<template>
    <h2 class="text-2xl font-semibold mb-6">Change Password</h2>

<form @submit.prevent="handleSubmit" class="grid grid-cols-12 gap-4">
  <!-- Current Password -->
  <div class="mb-4 col-span-12">
    <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
    <input type="password" v-model="form.current_password" class="input w-full"/>
    <span v-if="errors.current_password" class="text-red-500 text-sm">
      {{ Array.isArray(errors.current_password) ? errors.current_password[0] : errors.current_password }}
    </span>
  </div>

  <!-- New Password -->
  <div class="mb-4 col-span-12">
    <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
    <input class="input w-full" type="password" v-model="form.password"></input>
    <span v-if="errors.password" class="text-red-500 text-sm">
      {{ Array.isArray(errors.password) ? errors.password[0] : errors.password }}
    </span>
  </div>

  <!-- Password Confirmation -->
  <div class="mb-4 col-span-12">
    <label class="block text-sm font-medium text-gray-700 mb-1">Password Comfirm</label>
    <input type="password" v-model="form.password_confirmation" class="input w-full" />
    <span v-if="errors.password_confirmation" class="text-red-500 text-sm">
      {{ Array.isArray(errors.password_confirmation) ? errors.password_confirmation[0] : errors.password_confirmation }}
    </span>
  </div>


  <button type="submit" class="w-full col-span-12 bg-blue-600 text-white px-4 py-2 rounded cursor-pointer hover:bg-blue-700  disabled:opacity-50" :disabled="loading">
    <span v-if="loading">Loading...</span>
    <span v-else>Save</span>
  </button>
</form>
</template>

<script setup>
import { changePassword } from '@/services/auth';
import { ref } from 'vue';

const form = ref({
    current_password: '',
    password: '',
    password_confirmation: '',
})
const errors = ref({
    current_password: null,
    password: null,
    password_confirmation: null,
})
const loading = ref(false)

const handleSubmit = async () => {
    errors.value = {
        current_password: null,
        password: null,
        password_confirmation: null,
    }
    loading.value = true
    const changePasswordErrors = await changePassword(
        {
            current_password: form.value.current_password,
            password: form.value.password,
            password_confirmation: form.value.password_confirmation,
        },
        (isLoading) => {
            loading.value = isLoading
        },
    )
    if (changePasswordErrors) {
        errors.value = changePasswordErrors
    }
}
</script>