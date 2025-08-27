import { defineStore } from 'pinia'
import { ref, watch } from 'vue'

export const useUserStore = defineStore('user', () => {
  const user = ref(null)

  // Load từ sessionStorage khi khởi tạo
  const initUser = () => {
    const stored = sessionStorage.getItem('user')
    if (stored) {
      user.value = JSON.parse(stored)
    }
  }

  // Theo dõi user → lưu sessionStorage
  watch(user, (newVal) => {
    if (newVal) {
      sessionStorage.setItem('user', JSON.stringify(newVal))
    } else {
      sessionStorage.removeItem('user')
    }
  })

  return {
    user,
    initUser
  }
})
