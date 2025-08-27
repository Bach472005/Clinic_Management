<template>
    <div class="w-full max-w-md mx-auto mt-8">
      <h2 class="text-xl font-bold mb-4 text-center">Register</h2>
      <form @submit.prevent="handleSubmit">
        <div class="mb-4">
          <input
            v-model="form.name"
            placeholder="Name"
            class="block w-full p-2 border border-gray-300 rounded"
            :class="{ 'border-red-500': errors.name }"
          />
          <span v-if="errors.name" class="text-red-500 text-sm">
            {{ Array.isArray(errors.name) ? errors.name[0] : errors.name }}
          </span>
        </div>

        <!-- Email Field -->
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

        <!-- Password Field -->
        <div class="mb-4">
          <input
            v-model="form.password"
            type="password"
            placeholder="Password"
            class="block w-full p-2 border border-gray-300 rounded"
            :class="{ 'border-red-500': errors.password }"
          />
          <span v-if="errors.password" class="text-red-500 text-sm">
            {{ Array.isArray(errors.password) ? errors.password[0] : errors.name }}
          </span>
        </div>

        <!-- Confirm Password Field -->
        <div class="mb-4">
          <input
            v-model="form.password_confirmation"
            type="password"
            placeholder="Confirm Password"
            class="block w-full p-2 border border-gray-300 rounded"
            :class="{ 'border-red-500': errors.password_confirmation }"
          />
          <span v-if="errors.password_confirmation" class="text-red-500 text-sm">
            {{ Array.isArray(errors.password_confirmation) ? errors.password_confirmation[0] : errors.password_confirmation }}
          </span>
        </div>

        <!-- Submit Button -->
        <button
          type="submit"
          class="w-full bg-indigo-500 text-white px-4 py-2 rounded disabled:opacity-50 cursor-pointer"
          :disabled="loading"
        >
          <span v-if="loading">Loading</span>
          <span v-else>Sign up</span>
        </button>
      </form>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { register } from '@/services/auth'

const loading = ref(false);

const form = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

const errors = ref({
  name: null,
  email: null,
  password: null,
  password_confirmation: null,
})

const handleSubmit = async () => {
  errors.value = {
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
  }
  const registerErrors = await register(
    {
      name: form.value.name,
      email: form.value.email,
      password: form.value.password,
      password_confirmation: form.value.password_confirmation,
    },
    (isLoading) => {
      loading.value = isLoading
    },
  )

  if (registerErrors) {
    errors.value = registerErrors
  }
}
</script>