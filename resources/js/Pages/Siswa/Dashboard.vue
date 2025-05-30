<template>
  <SiswaLayout>
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl p-6 shadow-md mb-6">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
          <h1 class="text-2xl font-bold text-white mb-1">Daftar PKL</h1>
          <p class="text-blue-100 text-sm">Kelola data Praktik Kerja Lapangan Anda</p>
        </div>
        
        <div class="flex gap-3">
          <div class="relative w-full md:w-64">
            <input
              type="search"
              v-model="search"
              placeholder="Cari PKL..."
              class="w-full border-0 bg-white/10 backdrop-blur-sm text-white placeholder-blue-200 p-2 pl-9 rounded-lg focus:outline-none focus:ring-2 focus:ring-white/50"
            />
            <MagnifyingGlassIcon class="w-5 h-5 text-blue-200 absolute left-2 top-2.5" />
          </div>
          
          <button 
            v-if="!props.hasExistingPkl"
            @click="showAddModal = true"
            class="flex items-center gap-2 bg-white px-4 py-2 rounded-lg text-blue-700 font-medium hover:bg-blue-50 transition-colors shadow-sm"
          >
            <PlusIcon class="w-5 h-5" />
            Tambah PKL
          </button>
          <div v-else class="flex items-center gap-2 bg-blue-800 px-4 py-2 rounded-lg text-white text-sm shadow-sm">
            <span>Kamu sudah terdaftar PKL</span>
          </div>
        </div>
      </div>
    </div>

    <div class="md:hidden space-y-4">
      <div 
        v-for="(item, index) in filteredPkls" 
        :key="item.id"
        class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:border-blue-200 transition-colors"
      >
        <div class="border-b border-gray-100 px-4 py-3 bg-gray-50 flex justify-between items-center">
          <span class="font-medium text-gray-700">#{{ index + 1 }}</span>
          <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">{{ item.nama }}</span>
        </div>
        <div class="p-4 space-y-3">
          <div class="grid grid-cols-2 gap-3">
            <div>
              <p class="text-xs text-gray-500">Industri</p>
              <p class="font-medium">{{ item.industri }}</p>
            </div>
            <div>
              <p class="text-xs text-gray-500">Guru Pembimbing</p>
              <p class="font-medium">{{ item.guru || 'Belum ditentukan' }}</p>
            </div>
            <div>
              <p class="text-xs text-gray-500">Mulai</p>
              <p class="font-medium">{{ item.mulai }}</p>
            </div>
            <div>
              <p class="text-xs text-gray-500">Selesai</p>
              <p class="font-medium">{{ item.selesai }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="hidden md:block overflow-hidden rounded-xl shadow-sm border border-gray-200">
      <table class="min-w-full divide-y divide-gray-200 text-sm">
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
            v-for="(item, index) in filteredPkls"
            :key="item.id"
            class="hover:bg-gray-50 transition-colors"
          >
            <td class="px-4 py-3 text-gray-700">
              {{ index + 1 }}
            </td>
            <td class="px-4 py-3 text-gray-700 font-medium">{{ item.nama }}</td>
            <td class="px-4 py-3 text-gray-700">{{ item.industri }}</td>
            <td class="px-4 py-3 text-gray-700">{{ item.mulai }}</td>
            <td class="px-4 py-3 text-gray-700">{{ item.selesai }}</td>
            <td class="px-4 py-3 text-gray-700">{{ item.guru || 'Belum ditentukan' }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="filteredPkls.length === 0" class="text-center py-16 bg-white rounded-xl shadow-sm mt-4">
      <DocumentTextIcon class="w-16 h-16 text-gray-300 mx-auto mb-4" />
      <h3 class="text-lg font-medium text-gray-500 mb-1">Belum ada data PKL</h3>
      <p class="text-gray-400 mb-6">Kamu belum memiliki data PKL yang terdaftar</p>
      <button 
        v-if="!props.hasExistingPkl"
        @click="showAddModal = true"
        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors inline-flex items-center gap-2"
      >
        <PlusIcon class="w-5 h-5" />
        Tambah PKL Baru
      </button>
    </div>

    <div v-if="showAddModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl shadow-xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
          <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Tambah Data PKL</h2>
            <button @click="showAddModal = false" class="text-gray-500 hover:text-gray-700">
              <XMarkIcon class="w-6 h-6" />
            </button>
          </div>
        </div>
        
        <form @submit.prevent="submitPkl" class="p-6 space-y-5">
          <div>
            <label for="industri" class="block text-sm font-medium text-gray-700 mb-1">
              Industri / Tempat PKL <span class="text-red-500">*</span>
            </label>
            <select
              v-model="form.industri_id"
              id="industri"
              class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
              :class="{ 'border-red-500': form.errors.industri_id }"
              required
            >
              <option value="" disabled selected>Pilih Industri</option>
              <option v-for="industri in industries" :key="industri.id" :value="industri.id">
                {{ industri.nama }} - {{ industri.bidang_usaha }}
              </option>
            </select>
            <div v-if="form.errors.industri_id" class="text-sm text-red-600 mt-1">
              {{ form.errors.industri_id }}
            </div>
          </div>
          
          <div>
            <label for="guru_id" class="block text-sm font-medium text-gray-700 mb-1">
              Guru Pembimbing <span class="text-red-500">*</span>
            </label>
            <select
              v-model="form.guru_id"
              id="guru_id"
              class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
              :class="{ 'border-red-500': form.errors.guru_id }"
              required
            >
              <option value="" disabled selected>Pilih Guru</option>
              <option v-for="guru in gurus" :key="guru.id" :value="guru.id">
                {{ guru.nama }}
              </option>
            </select>
            <div v-if="form.errors.guru_id" class="text-sm text-red-600 mt-1">
              {{ form.errors.guru_id }}
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label for="mulai" class="block text-sm font-medium text-gray-700 mb-1">
                Tanggal Mulai <span class="text-red-500">*</span>
              </label>
              <input
                v-model="form.mulai"
                type="date"
                id="mulai"
                class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                :class="{ 'border-red-500': form.errors.mulai }"
                required
              />
              <div v-if="form.errors.mulai" class="text-sm text-red-600 mt-1">
                {{ form.errors.mulai }}
              </div>
            </div>

            <div>
              <label for="selesai" class="block text-sm font-medium text-gray-700 mb-1">
                Tanggal Selesai <span class="text-red-500">*</span>
              </label>
              <input
                v-model="form.selesai"
                type="date"
                id="selesai"
                class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                :class="{ 'border-red-500': form.errors.selesai }"
                required
              />
              <div v-if="form.errors.selesai" class="text-sm text-red-600 mt-1">
                {{ form.errors.selesai }}
              </div>
            </div>
          </div>

          <div class="flex justify-end gap-3 pt-4">
            <button
              type="button"
              @click="showAddModal = false"
              class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors"
            >
              Batal
            </button>
            <button
              type="submit"
              class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors"
              :disabled="form.processing"
            >
              <span v-if="form.processing">Menyimpan...</span>
              <span v-else>Simpan Data PKL</span>
            </button>
          </div>
        </form>
      </div>
    </div>

    <div v-if="showAlert" class="fixed bottom-4 right-4 bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-lg shadow-md max-w-md">
      <div class="flex items-center gap-2">
        <ExclamationTriangleIcon class="w-5 h-5 text-red-600" />
        <span class="font-medium">{{ alertMessage }}</span>
      </div>
      <button @click="showAlert = false" class="absolute top-2 right-2 text-red-500 hover:text-red-700">
        <XMarkIcon class="w-5 h-5" />
      </button>
    </div>
  </SiswaLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { router, Link, useForm } from '@inertiajs/vue3' 
import SiswaLayout from '@/Layouts/SiswaLayout.vue'
import { 
  PlusIcon,
  DocumentTextIcon,
  ChevronLeftIcon,
  ChevronRightIcon,
  MagnifyingGlassIcon,
  XMarkIcon,
  ExclamationTriangleIcon
} from '@heroicons/vue/24/outline'

const props = defineProps({
  pkls: Object,
  filters: Object,
  industries: Array,
  gurus: Array,
  hasExistingPkl: Boolean,
  errors: Object
})

const search = ref(props.filters?.search || '')
const showAddModal = ref(false)
const showAlert = ref(false)
const alertMessage = ref('')

const form = useForm({
  industri_id: '',
  guru_id: '',
  mulai: '',
  selesai: '',
})

const filteredPkls = computed(() => {
  if (!search.value) return props.pkls.data

  const searchTerm = search.value.toLowerCase()
  return props.pkls.data.filter(pkl => 
    (pkl.nama && pkl.nama.toLowerCase().includes(searchTerm)) || 
    (pkl.industri && pkl.industri.toLowerCase().includes(searchTerm)) ||
    (pkl.guru && pkl.guru.toLowerCase().includes(searchTerm))
  )
})

function submitPkl() {
  form.post('/siswa/pkl/store', {
    onSuccess: () => {
      showAddModal.value = false
      form.reset()
      router.reload()
    },
    onError: (errors) => {
      if (errors.message) {
        alertMessage.value = errors.message
        showAlert.value = true
        setTimeout(() => {
          showAlert.value = false
        }, 5000)
      }
    }
  })
}

onMounted(() => {
  const url = new URL(window.location.href)
  const error = url.searchParams.get('error')
  if (error) {
    alertMessage.value = error
    showAlert.value = true
    setTimeout(() => {
      showAlert.value = false
    }, 5000)
  }
  
  if (props.hasExistingPkl) {
    showAddModal.value = false
  }
})
</script>