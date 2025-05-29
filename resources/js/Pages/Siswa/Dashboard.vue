<template>
  <SiswaLayout>
    <h1 class="text-xl font-bold mb-4">Daftar PKL</h1>

    <div class="mb-4">
      <input
        v-model="search"
        @input="getPkls"
        placeholder="Cari siswa atau industri..."
        class="border p-2 rounded w-1/3"
      />
    </div>

    <table class="min-w-full bg-white rounded shadow">
      <thead>
        <tr class="bg-gray-100 text-left">
          <th class="p-3">Nama Siswa</th>
          <th class="p-3">Industri</th>
          <th class="p-3">Mulai</th>
          <th class="p-3">Selesai</th>
          <th class="p-3">Guru Pembimbing</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in pkls.data" :key="item.id" class="border-b">
          <td class="p-3">{{ item.nama }}</td>
          <td class="p-3">{{ item.industri }}</td>
          <td class="p-3">{{ item.mulai }}</td>
          <td class="p-3">{{ item.selesai }}</td>
          <td class="p-3">{{ item.guru }}</td>
        </tr>
      </tbody>
    </table>

    <div class="flex gap-2 mt-4">
      <button
        v-if="pkls.prev_page_url"
        @click="changePage(pkls.current_page - 1)"
        class="px-4 py-2 bg-gray-200 rounded"
      >
        Prev
      </button>
      <button
        v-if="pkls.next_page_url"
        @click="changePage(pkls.current_page + 1)"
        class="px-4 py-2 bg-gray-200 rounded"
      >
        Next
      </button>
    </div>
  </SiswaLayout>
</template>


//Script Setup
<script setup>
import { defineProps } from 'vue'
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'
import SiswaLayout from '@/Layouts/SiswaLayout.vue'

const props = defineProps({
  pkls: Object,
  filters: Object
})

const search = ref(props.filters.search || '')

const getPkls = () => {
  router.get(route('pkls.index'), { search: search.value }, {
    preserveState: true,
    replace: true,
  })
}

const changePage = (page) => {
  router.get(route('pkls.index'), { search: search.value, page }, {
    preserveState: true,
    replace: true,
  })
}
</script>
