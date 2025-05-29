<template>
  <div class="flex flex-col md:flex-row h-screen bg-gray-100">
    <!-- Sidebar Desktop -->
    <aside class="hidden md:flex md:flex-col md:w-64 bg-white shadow-md p-4">
      <h2 class="text-xl font-bold mb-6">Dashboard Siswa</h2>
      <nav class="space-y-2 flex-grow">
        <Link
          href="/dashboard"
          class="flex items-center gap-2 py-2 px-4 rounded hover:bg-gray-200"
          :class="route().current('siswa.dashboard') ? 'bg-gray-200 font-semibold text-blue-600' : 'text-gray-700'"
        >
          <HomeIcon class="w-5 h-5" :class="route().current('siswa.dashboard') ? 'text-blue-600' : 'text-gray-500'" />
          Home
        </Link>

        <Link
          href="/siswa/industri"
          class="flex items-center gap-2 py-2 px-4 rounded hover:bg-gray-200"
          :class="route().current('siswa.industri') ? 'bg-gray-200 font-semibold text-blue-600' : 'text-gray-700'"
        >
          <BuildingOfficeIcon class="w-5 h-5" :class="route().current('siswa.industri') ? 'text-blue-600' : 'text-gray-500'" />
          Industri
        </Link>
      </nav>

      <!-- Profil Desktop -->
      <div class="mt-auto relative">
        <button
          @click="toggleProfile"
          class="w-full flex items-center justify-between px-4 py-2 rounded hover:bg-gray-100"
        >
          <div class="flex items-center gap-2">
            <UserCircleIcon class="w-6 h-6 text-gray-600" />
            <span class="text-sm text-gray-700 font-medium truncate">{{ user.name }}</span>
          </div>
          <ChevronDownIcon class="w-4 h-4 text-gray-500" />
        </button>

        <div
          v-if="isProfileOpen && !isMobile"
          class="absolute bottom-14 left-4 right-4 bg-white border rounded shadow z-50"
        >
          <Link href="/siswa/profil" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100">
            <UserCircleIcon class="w-5 h-5 text-gray-500" />
            Profil
          </Link>
          <button
            @click="logout"
            class="flex items-center gap-2 w-full px-4 py-2 text-red-600 hover:bg-red-100"
          >
            <ArrowRightOnRectangleIcon class="w-5 h-5 text-red-500" />
            Logout
          </button>
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto p-6">
      <slot />
    </main>

    <!-- Bottom Navbar Mobile -->
    <nav
      class="fixed bottom-0 left-0 right-0 bg-white shadow-inner border-t border-gray-200 flex justify-around items-center md:hidden h-14 z-40"
    >
      <Link
        href="/dashboard"
        class="flex flex-col items-center justify-center py-2 px-3"
        :class="route().current('siswa.dashboard') ? 'bg-gray-200 font-semibold text-blue-600' : 'text-gray-700'"
      >
        <HomeIcon class="w-5 h-5" :class="route().current('siswa.dashboard') ? 'text-blue-600' : 'text-gray-500'" />
        <span class="text-xs">Home</span>
      </Link>

      <Link
        href="/siswa/industri"
        class="flex flex-col items-center justify-center py-2 px-3"
        :class="route().current('siswa.industri') ? 'text-blue-600 font-semibold' : 'text-gray-700'"
      >
        <BuildingOfficeIcon class="w-6 h-6 mb-0.5" :class="route().current('siswa.industri') ? 'text-blue-600' : 'text-gray-500'" />
        <span class="text-xs">Industri</span>
      </Link>

      <button
        @click="toggleProfile"
        class="flex flex-col items-center justify-center text-gray-600 hover:text-blue-600 focus:outline-none py-2 px-3"
      >
        <UserCircleIcon class="w-6 h-6 mb-0.5" />
        <span class="text-xs truncate max-w-[70px]">{{ user.name }}</span>
      </button>
    </nav>

    <!-- Modal Dropdown untuk Mobile -->
    <div
      v-if="isProfileOpen && isMobile"
      class="fixed inset-0 bg-black bg-opacity-40 flex items-end z-50 md:hidden"
      @click.self="isProfileOpen = false"
    >
      <div class="bg-white w-full rounded-t-lg shadow-lg py-4 px-6">
        <p class="text-sm text-gray-500 mb-2">Masuk sebagai:</p>
        <div class="flex items-center gap-2 mb-4">
          <UserCircleIcon class="w-6 h-6 text-gray-700" />
          <span class="font-medium">{{ user.name }}</span>
        </div>

        <Link href="/siswa/profil" class="flex items-center gap-2 py-2 hover:bg-gray-100 rounded px-2">
          <UserCircleIcon class="w-5 h-5 text-gray-500" />
          Profil
        </Link>

        <button
          @click="logout"
          class="flex items-center gap-2 w-full py-2 text-red-600 hover:bg-red-100 rounded px-2 mt-2"
        >
          <ArrowRightOnRectangleIcon class="w-5 h-5 text-red-500" />
          Logout
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import {
  HomeIcon,
  BuildingOfficeIcon,
  UserCircleIcon,
  ChevronDownIcon,
  ArrowRightOnRectangleIcon
} from '@heroicons/vue/24/outline'

import { ref, onMounted, onBeforeUnmount } from 'vue'
import { router, Link, usePage } from '@inertiajs/vue3'

const isProfileOpen = ref(false)
const isMobile = ref(false)
const { props } = usePage()
const user = props.auth.user

function logout() {
  router.post('/logout')
}

function toggleProfile() {
  isProfileOpen.value = !isProfileOpen.value
}

function handleResize() {
  isMobile.value = window.innerWidth < 768
}

onMounted(() => {
  handleResize()
  window.addEventListener('resize', handleResize)
})

onBeforeUnmount(() => {
  window.removeEventListener('resize', handleResize)
})
</script>
