<script setup>
import { ref, onMounted, onBeforeUnmount, computed } from 'vue'
import { useUserStore } from '../stores/user'
import { logout } from '../services/auth'
import { useRouter, RouterLink } from 'vue-router'

const router = useRouter()
const userStore = useUserStore()
const user = computed(() => userStore.user)

onMounted(() => {
  userStore.initUser()
})

const isDropdownOpen = ref(false)
const dropdownRef = ref(null)

function toggleDropdown() {
  isDropdownOpen.value = !isDropdownOpen.value
}

const handleLogout = async () => {
  await logout()
  userStore.user = null
  router.push('/login')
}

const handleClickOutside = (event) => {
  if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
    isDropdownOpen.value = false
  }
}

onMounted(() => {
  window.addEventListener('click', handleClickOutside)
})
onBeforeUnmount(() => {
  window.removeEventListener('click', handleClickOutside)
})
</script>

<template>
  <header class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
      <RouterLink to="/" class="text-2xl font-bold text-indigo-600">Tâm Lý Học 365</RouterLink>

      <nav class="flex items-center space-x-6 relative">
        <RouterLink to="/" class="text-gray-700 hover:text-indigo-600">Trang chủ</RouterLink>
        <RouterLink to="/" class="text-gray-700 hover:text-indigo-600">Giới thiệu</RouterLink>
        <RouterLink to="/" class="text-gray-700 hover:text-indigo-600">Blog</RouterLink>
        <RouterLink to="/" class="text-gray-700 hover:text-indigo-600">Liên hệ</RouterLink>

        <!-- Dropdown button -->
        <div ref="dropdown" class="relative" @click="toggleDropdown">
          <div
            class="cursor-pointer flex items-center space-x-2 text-gray-700 hover:text-indigo-600"
          >
            <span v-if="user">👤 {{ user.name }}</span>
            <span v-else>🔐 Tài khoản</span>
            <svg
              class="w-4 h-4"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              viewBox="0 0 24 24"
            >
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
          </div>

          <!-- Dropdown menu -->
          <div
            v-if="isDropdownOpen"
            class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg z-50"
          >
            <template v-if="user">
              <RouterLink
                to="/profile"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                >Hồ sơ</RouterLink
              >
              <RouterLink
                to="/"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                >Cài đặt</RouterLink
              >
              <button
                @click="handleLogout"
                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 cursor-pointer"
              >
                Đăng xuất
              </button>
            </template>
            <template v-else>
              <RouterLink
                to="/login"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                >Đăng nhập</RouterLink
              >
              <RouterLink
                to="/register"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                >Đăng ký</RouterLink
              >
            </template>
          </div>
        </div>
      </nav>
    </div>
  </header>
</template>