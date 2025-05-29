<template>
  <div>
    <h1 class="text-2xl font-bold">Selamat Datang Guru!</h1>
    <p>Ini adalah halaman dashboard khusus guru.</p>
    <button
      @click="logout"
      class="mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600"
    >
      Logout
    </button>
  </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'

function logout() {
  router.post('/logout')
}
</script>

