<template>
  <div class="relative cursor-pointer" @click="editAvatar = true" title="Nhấn để đổi ảnh">
    <img
      :src="form.avatar_url"
      alt="Avatar"
      class="h-32 w-32 rounded-full object-cover border-2 border-blue-600"
    />

    <!-- Overlay khi hover -->
    <div
      v-if="!editAvatar"
      class="absolute inset-0 bg-white bg-opacity-30 rounded-full flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity text-black font-semibold"
    >
      Đổi ảnh
    </div>
  </div>

  <!-- Input đổi ảnh hiện khi editAvatar = true -->
  <div v-if="editAvatar" class="mt-4 w-full">
    <input
      type="text"
      v-model="form.avatar_url"
      placeholder="Nhập link ảnh mới"
      class="input w-full"
    />
    <div class="flex justify-end mt-2 gap-2">
      <button
        @click="editAvatar = false"
        class="px-3 py-1 border rounded text-gray-700 hover:bg-gray-100"
      >
        Hủy
      </button>
      <button
        @click="saveAvatar"
        class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
      >
        Lưu ảnh
      </button>
    </div>
  </div>

  <!-- Menu lựa chọn -->
  <nav class="mt-10 w-full">
    <ul class="">
      <li class="flex flex-col gap-2">
        <RouterLink
          to="/profile"
          class="nav-link"
          :class="{ 'active-link': $route.path === '/profile' }"
        >
          Thông tin cá nhân
        </RouterLink>

        <RouterLink
          to="/profile/change-password"
          class="nav-link"
          :class="{ 'active-link': $route.path === '/profile/change-password' }"
        >
          Đổi mật khẩu
        </RouterLink>

        <RouterLink
          to="/medical"
          class="nav-link"
          :class="{ 'active-link': $route.path.startsWith('/medical') }"
        >
          Thông tin bệnh án
        </RouterLink>
      </li>
    </ul>
  </nav>
</template>

<script setup>
import { ref } from 'vue'

const user = JSON.parse(sessionStorage.getItem('user'))
const form = ref({
  avatar_url: user.avatar_url,
})
</script>
