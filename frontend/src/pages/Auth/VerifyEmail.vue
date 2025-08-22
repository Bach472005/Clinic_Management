<script setup>
import { onMounted, ref } from 'vue'
import axios from 'axios'
import { useRoute, useRouter } from 'vue-router'
import GuestLayout from '@/layouts/GuestLayout.vue'

const route = useRoute()
const router = useRouter()

const message = ref('Đang xác thực email...')

onMounted(async () => {
  const id = route.params.id
  const hash = route.params.hash
  const token = sessionStorage.getItem('token')

  if (!token) {
    sessionStorage.setItem('verifyEmail', JSON.stringify({ id, hash }))

    router.push('/login')
    return
  }
  try {
    const response = await axios.get(`/email/verify/${userId}/${hash}`, {
      headers: {
        Authorization: `Bearer ${token}`, // hoặc lấy token đúng cách
      },
    })

    message.value = response.data.message
  } catch (error) {
    if (error.response) {
      message.value = error.response.data.message || 'Xác thực thất bại.'
    } else {
      message.value = 'Có lỗi xảy ra.'
    }
  }
})
</script>

<template>
  <GuestLayout>
    <div class="email-verify">
      <h2>{{ message }}</h2>
      <button @click="router.push('/login')">Đăng nhập</button>
    </div>
  </GuestLayout>
</template>
