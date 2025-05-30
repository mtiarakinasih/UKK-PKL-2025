<template>
  <SiswaLayout>
    <div class="space-y-8">
      <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl p-6 shadow-md">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
          <div>
            <h1 class="text-2xl font-bold text-white mb-1">Daftar Industri PKL</h1>
            <p class="text-blue-100 text-sm">Temukan tempat PKL yang sesuai dengan minat dan bakatmu</p>
          </div>
          
          <div class="flex gap-3">
            <div class="relative w-full md:w-64">
              <input
                type="search"
                v-model="search"
                placeholder="Cari industri..."
                class="w-full border-0 bg-white/10 backdrop-blur-sm text-white placeholder-blue-200 p-2 pl-9 rounded-lg focus:outline-none focus:ring-2 focus:ring-white/50"
              />
              <MagnifyingGlassIcon class="w-5 h-5 text-blue-200 absolute left-2 top-2.5" />
            </div>
            
            <button 
              @click="showAddModal = true"
              class="flex items-center gap-2 bg-white px-4 py-2 rounded-lg text-blue-700 font-medium hover:bg-blue-50 transition-colors shadow-sm"
            >
              <PlusIcon class="w-5 h-5" />
              Tambah Industri
            </button>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div 
          v-for="industri in filteredIndustries" 
          :key="industri.id"
          class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 hover:border-blue-200"
        >
          <div class="p-6">
            <div class="flex items-center justify-between mb-4">
              <h3 class="font-bold text-lg text-gray-800">{{ industri.nama }}</h3>
              <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                {{ industri.bidang_usaha }}
              </span>
            </div>
            
            <div class="space-y-3 text-sm">
              <div class="flex gap-2">
                <MapPinIcon class="w-5 h-5 text-blue-500 flex-shrink-0" />
                <p class="text-gray-600">{{ industri.alamat }}</p>
              </div>
              
              <div class="flex gap-2">
                <PhoneIcon class="w-5 h-5 text-blue-500 flex-shrink-0" />
                <p class="text-gray-600">{{ industri.kontak }}</p>
              </div>
              
              <div class="flex gap-2">
                <EnvelopeIcon class="w-5 h-5 text-blue-500 flex-shrink-0" />
                <p class="text-gray-600">{{ industri.email || 'Tidak tersedia' }}</p>
              </div>
              
              <div v-if="industri.website" class="flex gap-2">
                <GlobeAltIcon class="w-5 h-5 text-blue-500 flex-shrink-0" />
                <a 
                  :href="addHttpPrefix(industri.website)" 
                  target="_blank" 
                  class="text-blue-600 hover:underline"
                >
                  {{ industri.website }}
                </a>
              </div>
            </div>
          </div>
          
          <div class="bg-gray-50 px-6 py-3 border-t border-gray-100">
            <Link
              :href="`/siswa/pkl/add?industri=${industri.id}`"
              class="flex justify-between items-center text-blue-600 text-sm font-medium hover:text-blue-800 transition-colors"
            >
              <span>Pilih untuk PKL</span>
              <ArrowRightIcon class="w-4 h-4" />
            </Link>
          </div>
        </div>
      </div>

      <div v-if="filteredIndustries.length === 0" class="text-center py-16 bg-white rounded-xl shadow-sm">
        <DocumentTextIcon class="w-16 h-16 text-gray-300 mx-auto mb-4" />
        <h3 class="text-lg font-medium text-gray-500 mb-1">Tidak ada industri ditemukan</h3>
        <p class="text-gray-400 mb-6">Coba gunakan kata kunci pencarian yang berbeda</p>
        <button 
          @click="showAddModal = true"
          class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors inline-flex items-center gap-2"
        >
          <PlusIcon class="w-5 h-5" />
          Tambah Industri Baru
        </button>
      </div>
      
      <div v-if="showAddModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
          <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
              <h2 class="text-xl font-bold text-gray-800">Tambah Industri Baru</h2>
              <button @click="showAddModal = false" class="text-gray-500 hover:text-gray-700">
                <XMarkIcon class="w-6 h-6" />
              </button>
            </div>
          </div>
          
          <form @submit.prevent="submitIndustri" class="p-6 space-y-4">
            <div>
              <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Industri</label>
              <input
                v-model="form.nama"
                type="text"
                id="nama"
                class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                :class="{ 'border-red-500': form.errors.nama }"
              />
              <div v-if="form.errors.nama" class="text-sm text-red-600 mt-1">
                {{ form.errors.nama }}
              </div>
            </div>
            
            <div>
              <label for="bidang_usaha" class="block text-sm font-medium text-gray-700 mb-1">Bidang Usaha</label>
              <input
                v-model="form.bidang_usaha"
                type="text"
                id="bidang_usaha"
                class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                :class="{ 'border-red-500': form.errors.bidang_usaha }"
              />
              <div v-if="form.errors.bidang_usaha" class="text-sm text-red-600 mt-1">
                {{ form.errors.bidang_usaha }}
              </div>
            </div>
            
            <div>
              <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
              <textarea
                v-model="form.alamat"
                id="alamat"
                rows="3"
                class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                :class="{ 'border-red-500': form.errors.alamat }"
              ></textarea>
              <div v-if="form.errors.alamat" class="text-sm text-red-600 mt-1">
                {{ form.errors.alamat }}
              </div>
            </div>
            
            <div>
              <label for="kontak" class="block text-sm font-medium text-gray-700 mb-1">Kontak (Telepon)</label>
              <input
                v-model="form.kontak"
                type="text"
                id="kontak"
                class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                :class="{ 'border-red-500': form.errors.kontak }"
              />
              <div v-if="form.errors.kontak" class="text-sm text-red-600 mt-1">
                {{ form.errors.kontak }}
              </div>
            </div>
            
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email (Opsional)</label>
              <input
                v-model="form.email"
                type="email"
                id="email"
                class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                :class="{ 'border-red-500': form.errors.email }"
              />
              <div v-if="form.errors.email" class="text-sm text-red-600 mt-1">
                {{ form.errors.email }}
              </div>
            </div>
            
            <div>
              <label for="website" class="block text-sm font-medium text-gray-700 mb-1">Website (Opsional)</label>
              <input
                v-model="form.website"
                type="text"
                id="website"
                class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                :class="{ 'border-red-500': form.errors.website }"
              />
              <div v-if="form.errors.website" class="text-sm text-red-600 mt-1">
                {{ form.errors.website }}
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
                <span v-else>Simpan Industri</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </SiswaLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link, useForm } from '@inertiajs/vue3'
import SiswaLayout from '@/Layouts/SiswaLayout.vue'
import { 
  MagnifyingGlassIcon, 
  MapPinIcon, 
  PhoneIcon, 
  EnvelopeIcon, 
  GlobeAltIcon,
  DocumentTextIcon,
  PlusIcon,
  ArrowRightIcon,
  XMarkIcon
} from '@heroicons/vue/24/outline'

const props = defineProps({
  industries: Object,
  filters: Object
})

const search = ref(props.filters?.search || '')
const showAddModal = ref(false)

const form = useForm({
  nama: '',
  bidang_usaha: '',
  alamat: '',
  kontak: '',
  email: '',
  website: ''
})

const filteredIndustries = computed(() => {
  if (!search.value) return props.industries.data

  const searchTerm = search.value.toLowerCase()
  return props.industries.data.filter(industri => 
    industri.nama.toLowerCase().includes(searchTerm) || 
    industri.bidang_usaha.toLowerCase().includes(searchTerm) ||
    industri.alamat.toLowerCase().includes(searchTerm)
  )
})

function addHttpPrefix(url) {
  if (!url) return '';
  if (!url.startsWith('http://') && !url.startsWith('https://')) {
    return 'https://' + url
  }
  return url
}

function submitIndustri() {
  form.post('/siswa/industri/store', {
    onSuccess: () => {
      showAddModal.value = false
      form.reset()
    }
  })
}
</script>