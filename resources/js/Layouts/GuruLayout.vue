<template>
  <div class="flex flex-col md:flex-row h-screen bg-slate-50">
    <aside class="hidden md:flex md:flex-col md:w-64 bg-gradient-to-br from-white to-slate-50 shadow-lg rounded-r-xl p-5">
      <div class="flex items-center gap-3 mb-8">
        <h2 class="text-xl font-bold text-slate-800">Dashboard Guru</h2>
      </div>
      
      <nav class="space-y-1.5 flex-grow">
        <Link
          href="/guru/dashboard"
          class="flex items-center gap-3 py-2.5 px-4 rounded-lg transition-all duration-200 group"
          :class="route().current('guru.dashboard') ? 'bg-green-50 text-green-600' : 'text-slate-700 hover:bg-slate-100'"
        >
          <HomeIcon 
            class="w-5 h-5 transition-colors" 
            :class="route().current('guru.dashboard') ? 'text-green-600' : 'text-slate-500 group-hover:text-green-500'" 
          />
          <span class="font-medium">Home</span>
          <div 
            class="ml-auto h-2 w-2 rounded-full transition-all" 
            :class="route().current('guru.dashboard') ? 'bg-green-500' : 'bg-transparent'"
          ></div>
        </Link>
      </nav>

      <div class="mt-auto">
        <div class="border-t border-slate-200 my-4"></div>
        <div class="relative user-menu">
          <button 
            @click="toggleUserMenu"
            class="flex items-center gap-3 w-full px-4 py-3 hover:bg-slate-100 transition-colors rounded-lg"
          >
            <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
              <UserCircleIcon class="w-6 h-6 text-green-600" />
            </div>
            <div class="text-left overflow-hidden">
              <span class="text-sm font-medium text-slate-800 block truncate">{{ user.name }}</span>
              <span class="text-xs text-slate-500">Guru</span>
            </div>
            <ChevronUpIcon class="w-4 h-4 text-slate-500 ml-auto" :class="{ 'rotate-180': userMenuOpen }" />
          </button>
          
          <div 
            v-if="userMenuOpen" 
            class="absolute left-0 right-0 bottom-full mb-1 bg-white rounded-lg shadow-lg border border-slate-200 overflow-hidden w-full"
          >
            <button
              @click="logout"
              class="flex items-center gap-3 w-full px-4 py-3 text-red-600 hover:bg-red-50 transition-colors"
            >
              <ArrowRightOnRectangleIcon class="w-5 h-5 text-red-500" />
              <span>Logout</span>
            </button>
          </div>
        </div>
      </div>
    </aside>

    <main class="flex-1 overflow-y-auto p-6 md:p-8">
      <slot />
    </main>

    <nav
      class="fixed bottom-0 left-0 right-0 bg-white shadow-lg border-t border-slate-200 flex justify-around items-center md:hidden h-16 z-40 px-2"
    >
      <Link
        href="/guru/dashboard"
        class="flex flex-col items-center justify-center py-2 px-3 rounded-lg transition-all"
        :class="route().current('guru.dashboard') ? 'text-green-600' : 'text-slate-600'"
      >
        <div class="relative">
          <HomeIcon class="w-6 h-6" :class="route().current('guru.dashboard') ? 'text-green-600' : 'text-slate-500'" />
          <div 
            v-if="route().current('guru.dashboard')" 
            class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 h-1 w-4 bg-green-500 rounded-full"
          ></div>
        </div>
        <span class="text-xs mt-1 font-medium">Home</span>
      </Link>

      <Link
        href="/guru/bimbingan"
        class="flex flex-col items-center justify-center py-2 px-3 rounded-lg transition-all"
        :class="route().current('guru.bimbingan') ? 'text-green-600' : 'text-slate-600'"
      >
        <div class="relative">
          <UserGroupIcon class="w-6 h-6" :class="route().current('guru.bimbingan') ? 'text-green-600' : 'text-slate-500'" />
          <div 
            v-if="route().current('guru.bimbingan')" 
            class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 h-1 w-4 bg-green-500 rounded-full"
          ></div>
        </div>
        <span class="text-xs mt-1 font-medium">Bimbingan</span>
      </Link>

      <Link
        href="/guru/industri"
        class="flex flex-col items-center justify-center py-2 px-3 rounded-lg transition-all"
        :class="route().current('guru.industri') ? 'text-green-600' : 'text-slate-600'"
      >
        <div class="relative">
          <BuildingOfficeIcon class="w-6 h-6" :class="route().current('guru.industri') ? 'text-green-600' : 'text-slate-500'" />
          <div 
            v-if="route().current('guru.industri')" 
            class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 h-1 w-4 bg-green-500 rounded-full"
          ></div>
        </div>
        <span class="text-xs mt-1 font-medium">Industri</span>
      </Link>
    </nav>
    
    <div 
      v-if="userMenuOpen && isMobile" 
      class="fixed inset-0 bg-black bg-opacity-30 z-50 flex items-end justify-center"
      @click.self="userMenuOpen = false"
    >
      <div class="bg-white w-full max-w-sm rounded-t-xl p-4 animate-slide-up">
        <div class="flex items-center gap-3 mb-4 pb-3 border-b border-slate-100">
          <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
            <UserCircleIcon class="w-7 h-7 text-green-600" />
          </div>
          <div>
            <p class="font-medium">{{ user.name }}</p>
            <p class="text-xs text-slate-500">Guru</p>
          </div>
        </div>
        <button
          @click="logout"
          class="flex items-center gap-3 w-full px-4 py-3 text-red-600 hover:bg-red-50 transition-colors rounded-lg"
        >
          <ArrowRightOnRectangleIcon class="w-5 h-5 text-red-500" />
          <span>Logout</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { HomeIcon, BuildingOfficeIcon, UserCircleIcon, ChevronUpIcon, ArrowRightOnRectangleIcon, UserGroupIcon } from '@heroicons/vue/24/outline'
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { router, Link, usePage } from '@inertiajs/vue3'

const isMobile = ref(false)
const userMenuOpen = ref(false)
const { props } = usePage()
const user = props.auth.user

function logout() {
  router.post('/logout')
}

function toggleUserMenu() {
  userMenuOpen.value = !userMenuOpen.value
}

function handleResize() {
  isMobile.value = window.innerWidth < 768
}

function handleClickOutside(event) {
  if (userMenuOpen.value && !event.target.closest('.user-menu')) {
    userMenuOpen.value = false
  }
}

onMounted(() => {
  handleResize()
  window.addEventListener('resize', handleResize)
  document.addEventListener('click', handleClickOutside)
})

onBeforeUnmount(() => {
  window.removeEventListener('resize', handleResize)
  document.removeEventListener('click', handleClickOutside)
})
</script>

<style>
@keyframes slide-up {
  from {
    transform: translateY(100%);
  }
  to {
    transform: translateY(0);
  }
}

.animate-slide-up {
  animation: slide-up 0.3s ease-out forwards;
}
</style>