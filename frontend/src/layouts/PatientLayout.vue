<template>
    <div class="min-h-screen flex flex-col bg-gray-50 text-gray-800">
      <!-- Header -->
      <Header />
  
      <!-- Main Content -->
      <main class="flex-grow">
        <div class="mx-auto px-4 py-8">
          <slot></slot>
        </div>
      </main>
  
      <!-- Footer -->
      <Footer></Footer>
    </div>
  </template>
  
  <script setup>
  import Header from '@/components/Header.vue'
  import Footer from '@/components/Footer.vue'
  </script>
  
  <style scoped>
  /* Bạn có thể thêm hiệu ứng nhẹ nhàng ở đây nếu muốn */
  </style>
  