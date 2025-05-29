<template>
  <SiswaLayout>
    <h1 class="text-xl font-bold mb-4">Daftar PKL</h1>

    <div class="mb-4 flex justify-end">
      <input
        type="search"
        v-model="search"
        placeholder="Cari siswa atau industri..."
        class="border border-gray-300 p-2 rounded-lg w-1/3 focus:outline-none focus:ring-2 focus:ring-primary-500"
      />
    </div>


    <div class="overflow-hidden rounded-xl shadow ring-1 ring-gray-200">
      <table class="min-w-full divide-y divide-gray-100 text-sm">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-3 text-left font-semibold text-gray-600">No</th>
            <th class="px-4 py-3 text-left font-semibold text-gray-600">Nama Siswa</th>
            <th class="px-4 py-3 text-left font-semibold text-gray-600">Industri</th>
            <th class="px-4 py-3 text-left font-semibold text-gray-600">Mulai</th>
            <th class="px-4 py-3 text-left font-semibold text-gray-600">Selesai</th>
            <th class="px-4 py-3 text-left font-semibold text-gray-600">Guru Pembimbing</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 bg-white">
          <tr
            v-for="(item, index) in pkls.data"
            :key="item.id"
            class="hover:bg-gray-50 transition-colors"
          >
            <td class="px-4 py-3 text-gray-700">
              {{ (pkls.current_page - 1) * pkls.per_page + index + 1 }}
            </td>
            <td class="px-4 py-3 text-gray-700">{{ item.nama }}</td>
            <td class="px-4 py-3 text-gray-700">{{ item.industri }}</td>
            <td class="px-4 py-3 text-gray-700">{{ item.mulai }}</td>
            <td class="px-4 py-3 text-gray-700">{{ item.selesai }}</td>
            <td class="px-4 py-3 text-gray-700">{{ item.guru }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="flex gap-2 mt-4">
      <button
        v-if="pkls.prev_page_url"
        @click="changePage(pkls.current_page - 1)"
        class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors"
      >
        Prev
      </button>
      <button
        v-if="pkls.next_page_url"
        @click="changePage(pkls.current_page + 1)"
        class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors"
      >
        Next
      </button>
    </div>
  </SiswaLayout>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import SiswaLayout from '@/Layouts/SiswaLayout.vue'
import { route } from 'ziggy-js'


interface PklItem {
  id: number
  nama: string
  industri: string
  mulai: string
  selesai: string
  guru: string
}

interface PklPagination {
  data: PklItem[]
  current_page: number
  per_page: number
  next_page_url: string | null
  prev_page_url: string | null
}

const props = defineProps<{
  pkls: PklPagination
  filters: {
    search: string
  }
}>()

const search = ref(props.filters.search || '')

// Debounce manual 500ms
let timeout: number | undefined
watch(search, (val) => {
  if (timeout) clearTimeout(timeout)
  timeout = setTimeout(() => {
    router.get(route('pkls.index'), { search: val }, {
      preserveState: true,
      replace: true,
    })
  }, 500)
})
</script>
