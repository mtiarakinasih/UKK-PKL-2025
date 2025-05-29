<template>
  <div class="flex flex-col md:flex-row h-screen bg-gray-100">
    <!-- Sidebar Desktop -->
    <aside class="hidden md:flex md:flex-col md:w-64 bg-white shadow-md p-4">
      <h2 class="text-xl font-bold mb-6">Dashboard Siswa</h2>
      <nav class="space-y-2 flex-grow">
        <Link
          href="/dashboard"
          class="flex items-center gap-2 py-2 px-4 rounded hover:bg-gray-200"
          :class="route().current('dashboard') && 'bg-gray-200 font-semibold'"
        >
          <!-- Home icon -->
          <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 9.75L12 4l9 5.75v8.25A2.25 2.25 0 0118.75 20H5.25A2.25 2.25 0 013 18V9.75z" />
          </svg>
          Home
        </Link>

        <Link
          href="/siswa/industri"
          class="flex items-center gap-2 py-2 px-4 rounded hover:bg-gray-200"
          :class="route().current('siswa.industri') && 'bg-gray-200 font-semibold'"
        >
          <!-- Industri icon -->
          <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 21h16M4 10h16M4 6h16M9 21V6m6 15V6" />
          </svg>
          Industri
        </Link>
      </nav>

      <!-- Profil di paling bawah desktop -->
      <div class="mt-auto relative">
        <button
          @click="isProfileOpen = !isProfileOpen"
          class="w-full flex items-center justify-between px-4 py-2 rounded hover:bg-gray-100"
        >
          <div class="flex items-center gap-2">
            <!-- Avatar icon -->
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5.121 17.804A7.5 7.5 0 0112 15a7.5 7.5 0 016.879 2.804M12 12a4 4 0 100-8 4 4 0 000 8z" />
            </svg>
            <span class="text-sm text-gray-700 font-medium truncate">{{ user.name }}</span>
          </div>
          <!-- Dropdown arrow -->
          <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M19 9l-7 7-7-7" />
          </svg>
        </button>

        <div
          v-if="isProfileOpen"
          class="absolute bottom-14 left-4 right-4 bg-white border rounded shadow z-50"
        >
          <Link href="/siswa/profil" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5.121 17.804A7.5 7.5 0 0112 15a7.5 7.5 0 016.879 2.804M12 12a4 4 0 100-8 4 4 0 000 8z" />
            </svg>
            Profil
          </Link>
          <button
            @click="logout"
            class="flex items-center gap-2 w-full px-4 py-2 text-red-600 hover:bg-red-100"
          >
            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5" />
            </svg>
            Logout
          </button>
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto p-6">
      <slot />
    </main>

    <!-- Bottom Navbar untuk Mobile -->
    <nav
      class="fixed bottom-0 left-0 right-0 bg-white shadow-inner border-t border-gray-200 flex justify-around items-center md:hidden h-14"
    >
      <Link
        href="/dashboard"
        class="flex flex-col items-center justify-center text-gray-600 hover:text-blue-600"
        :class="route().current('dashboard') && 'text-blue-600'"
      >
        <svg class="w-6 h-6 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M3 9.75L12 4l9 5.75v8.25A2.25 2.25 0 0118.75 20H5.25A2.25 2.25 0 013 18V9.75z" />
        </svg>
        <span class="text-xs">Home</span>
      </Link>

      <Link
        href="/siswa/industri"
        class="flex flex-col items-center justify-center text-gray-600 hover:text-blue-600"
        :class="route().current('siswa.industri') && 'text-blue-600'"
      >
        <svg class="w-6 h-6 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 21h16M4 10h16M4 6h16M9 21V6m6 15V6" />
        </svg>
        <span class="text-xs">Industri</span>
      </Link>

      <div class="relative">
        <button
          @click="isProfileOpen = !isProfileOpen"
          class="flex flex-col items-center justify-center text-gray-600 hover:text-blue-600 focus:outline-none"
        >
          <svg class="w-6 h-6 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M5.121 17.804A7.5 7.5 0 0112 15a7.5 7.5 0 016.879 2.804M12 12a4 4 0 100-8 4 4 0 000 8z" />
          </svg>
          <span class="text-xs truncate max-w-[70px]">{{ user.name }}</span>
        </button>

        <div
          v-if="isProfileOpen"
          class="absolute bottom-14 left-0 right-0 bg-white border rounded shadow z-50"
        >
          <Link href="/siswa/profil" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5.121 17.804A7.5 7.5 0 0112 15a7.5 7.5 0 016.879 2.804M12 12a4 4 0 100-8 4 4 0 000 8z" />
            </svg>
            Profil
          </Link>
          <button
            @click="logout"
            class="flex items-center gap-2 w-full px-4 py-2 text-red-600 hover:bg-red-100"
          >
            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5" />
            </svg>
            Logout
          </button>
        </div>
      </div>
    </nav>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { router, Link, usePage } from '@inertiajs/vue3'

const isProfileOpen = ref(false)

const { props } = usePage()
const user = props.auth.user

function logout() {
  router.post('/logout')
}
</script>
