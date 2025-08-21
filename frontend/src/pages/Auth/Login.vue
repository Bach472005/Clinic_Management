<template>
  <GuestLayout>
    <div class="w-full max-w-md mx-auto mt-8">
      <h2 class="text-xl font-bold mb-4 text-center">Login</h2>
      <form @submit.prevent="handleSubmit">
        <div class="mb-4">
          <input
            v-model="form.email"
            type="email"
            placeholder="Email"
            class="block w-full p-2 border border-gray-300 rounded"
            :class="{ 'border-red-500': errors.email }"
          />
          <span v-if="errors.email" class="text-red-500 text-sm">
            {{ Array.isArray(errors.email) ? errors.email[0] : errors.email }}
          </span>
        </div>
        <div class="mb-4">
          <input
            v-model="form.password"
            type="password"
            placeholder="Password"
            class="block w-full p-2 border border-gray-300 rounded"
            :class="{ 'border-red-500': errors.password }"
          />
          <span v-if="errors.password" class="text-red-500 text-sm">
            {{ Array.isArray(errors.password) ? errors.password[0] : errors.password }}
          </span>
        </div>
        <button
          type="submit"
          class="w-full bg-blue-500 text-white px-4 py-2 rounded disabled:opacity-50"
          :disabled="loading"
        >
          <span v-if="loading">Loading...</span>
          <span v-else>Login</span>
        </button>
      </form>
    </div>
  </GuestLayout>
</template>

<script setup>
import { ref } from 'vue'
import GuestLayout from '@/layouts/GuestLayout.vue'
import { login } from '@/services/auth'

const form = ref({
  email: '',
  password: ''
})
const errors = ref({
  email: null,
  password: null
})
const loading = ref(false)

const handleSubmit = async () => {
  errors.value = {
    email: null,
    password: null
  }
  loading.value = true
  const loginErrors = await login(
    {
      email: form.value.email,
      password: form.value.password
    },
    (isLoading) => {
      loading.value = isLoading
    },
  )
  if (loginErrors) {
    errors.value = loginErrors
  }
}
</script>
