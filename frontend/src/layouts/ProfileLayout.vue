<template>
  <GuestLayout>
    <div class="p-6 bg-white shadow-md rounded-md flex gap-8">
      <!-- Sidebar trái -->
      <div class="w-1/3 flex flex-col items-center">
        <Menu></Menu>
      </div>

      <!-- Nội dung bên phải -->
      <div class="flex-1 min-h-[400px]">
        <router-view></router-view>
      </div>
    </div>
  </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/layouts/GuestLayout.vue'
import Menu from '@/pages/Auth/Components/Menu.vue'

// Submit handler
const submitProfile = () => {
  console.log('Dữ liệu gửi đi:', form.value)
  // Gửi API cập nhật hồ sơ tại đây...
}
</script>
