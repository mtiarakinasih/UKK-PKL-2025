<template>
  <GuruLayout>
    <div class="space-y-6">
      <div class="bg-gradient-to-r from-green-600 to-teal-700 rounded-xl p-6 shadow-md">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
          <div>
            <h1 class="text-2xl font-bold text-white mb-2">Dashboard Guru</h1>
            <p class="text-green-100">Monitoring siswa PKL</p>
          </div>
          <div class="flex gap-2">
            <div class="relative">
              <input
                type="search"
                v-model="search"
                placeholder="Cari siswa..."
                class="w-full md:w-64 pl-10 pr-4 py-2 text-sm bg-white/20 backdrop-blur-sm text-white placeholder-green-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-white/50"
              />
              <MagnifyingGlassIcon class="w-5 h-5 text-white absolute left-3 top-2.5" />
            </div>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-sm p-4 flex">
        <button 
          @click="activeFilter = 'all'" 
          class="px-4 py-2 rounded-lg transition-colors font-medium"
          :class="activeFilter === 'all' ? 'bg-green-100 text-green-700' : 'text-gray-600 hover:bg-gray-100'"
        >
          Semua Siswa
        </button>
        <button 
          @click="activeFilter = 'active'" 
          class="px-4 py-2 rounded-lg transition-colors font-medium ml-2"
          :class="activeFilter === 'active' ? 'bg-green-100 text-green-700' : 'text-gray-600 hover:bg-gray-100'"
        >
          Sedang PKL
        </button>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">Total Siswa</h3>
            <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
              <UserGroupIcon class="w-6 h-6 text-green-600" />
            </div>
          </div>
          <p class="text-3xl font-bold mt-4 mb-1">{{ stats.totalStudents }}</p>
          <p class="text-sm text-gray-500">Siswa terdaftar</p>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">Total Industri</h3>
            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
              <BuildingOfficeIcon class="w-6 h-6 text-blue-600" />
            </div>
          </div>
          <p class="text-3xl font-bold mt-4 mb-1">{{ stats.totalIndustries }}</p>
          <p class="text-sm text-gray-500">Tempat PKL</p>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">PKL Aktif</h3>
            <div class="h-10 w-10 rounded-full bg-amber-100 flex items-center justify-center">
              <CalendarIcon class="w-6 h-6 text-amber-600" />
            </div>
          </div>
          <p class="text-3xl font-bold mt-4 mb-1">{{ stats.activePkl }}</p>
          <p class="text-sm text-gray-500">Siswa sedang PKL</p>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-100">
          <h2 class="text-lg font-semibold text-gray-800">
            {{ activeFilter === 'all' ? 'Daftar Semua Siswa' : 'Daftar Siswa PKL Aktif' }}
          </h2>
        </div>
        
        <div class="hidden md:block overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status PKL</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tempat PKL</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mulai</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Selesai</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="(student, index) in filteredAndSortedStudents" :key="student.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ index + 1 }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-medium">
                      {{ student.nama.charAt(0) }}
                    </div>
                    <div class="ml-3">
                      <div class="text-sm font-medium text-gray-900">{{ student.nama }}</div>
                      <div class="text-sm text-gray-500">{{ student.nis }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span 
                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full" 
                    :class="student.status_pkl ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800'"
                  >
                    {{ student.status_pkl ? 'Aktif PKL' : 'Tidak PKL' }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ student.pkl ? student.pkl.industri : '-' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ student.pkl ? formatDate(student.pkl.mulai) : '-' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ student.pkl ? formatDate(student.pkl.selesai) : '-' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <button 
                    @click="showStudentDetail(student)"
                    class="text-green-600 hover:text-green-900"
                    :disabled="!student.pkl"
                    :class="{'opacity-50 cursor-not-allowed': !student.pkl}"
                  >
                    Detail
                  </button>
                </td>
              </tr>
              
              <tr v-if="filteredAndSortedStudents.length === 0">
                <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                  <DocumentTextIcon class="mx-auto h-12 w-12 text-gray-400" />
                  <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data</h3>
                  <p class="mt-1 text-sm text-gray-500">
                    {{ activeFilter === 'all' ? 'Belum ada siswa yang terdaftar' : 'Belum ada siswa yang sedang PKL saat ini' }}
                  </p>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="md:hidden divide-y divide-gray-200">
          <div 
            v-for="(student, index) in filteredAndSortedStudents" 
            :key="student.id"
            class="p-4 hover:bg-gray-50"
          >
            <div class="flex justify-between items-start mb-2">
              <div class="flex items-center">
                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-medium">
                  {{ student.nama.charAt(0) }}
                </div>
                <div class="ml-3">
                  <div class="text-sm font-medium text-gray-900">{{ student.nama }}</div>
                  <div class="text-xs text-gray-500">{{ student.nis }}</div>
                </div>
              </div>
              <span 
                class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full" 
                :class="student.status_pkl ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800'"
              >
                {{ student.status_pkl ? 'Aktif PKL' : 'Tidak PKL' }}
              </span>
            </div>
            
            <div v-if="student.pkl" class="ml-13 grid grid-cols-2 gap-y-2 text-sm mt-3">
              <div>
                <span class="text-gray-500">Tempat PKL:</span>
                <p class="font-medium">{{ student.pkl.industri }}</p>
              </div>
              <div>
                <span class="text-gray-500">Mulai:</span>
                <p class="font-medium">{{ formatDate(student.pkl.mulai) }}</p>
              </div>
              <div>
                <span class="text-gray-500">Selesai:</span>
                <p class="font-medium">{{ formatDate(student.pkl.selesai) }}</p>
              </div>
            </div>
            
            <button 
              v-if="student.pkl"
              @click="showStudentDetail(student)"
              class="mt-3 w-full py-2 bg-green-50 text-green-700 rounded-lg flex items-center justify-center font-medium"
            >
              <EyeIcon class="w-4 h-4 mr-2" />
              Lihat Detail
            </button>
          </div>
          
          <div v-if="filteredAndSortedStudents.length === 0" class="p-10 text-center text-gray-500">
            <DocumentTextIcon class="mx-auto h-12 w-12 text-gray-400" />
            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data</h3>
            <p class="mt-1 text-sm text-gray-500">
              {{ activeFilter === 'all' ? 'Belum ada siswa yang terdaftar' : 'Belum ada siswa yang sedang PKL saat ini' }}
            </p>
          </div>
        </div>
      </div>
    </div>

    <div
      v-if="selectedStudent && selectedStudent.pkl"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"
      @click.self="selectedStudent = null"
    >
      <div class="bg-white rounded-xl shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Detail Siswa PKL</h3>
            <button @click="selectedStudent = null" class="text-gray-400 hover:text-gray-500">
              <XMarkIcon class="h-5 w-5" />
            </button>
          </div>
        </div>
        
        <div class="p-6">
          <div class="flex items-center mb-6">
            <div class="h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xl">
              {{ selectedStudent.nama.charAt(0) }}
            </div>
            <div class="ml-4">
              <h3 class="text-lg font-semibold text-gray-900">{{ selectedStudent.nama }}</h3>
              <div class="text-gray-500">NIS: {{ selectedStudent.nis }}</div>
            </div>
          </div>
          
          <div class="space-y-4">
            <div class="border-t border-gray-200 pt-4">
              <h4 class="font-semibold text-gray-900 mb-3">Informasi PKL</h4>
              
              <div class="space-y-3">
                <div>
                  <p class="text-sm text-gray-500 mb-1">Periode PKL</p>
                  <p class="font-medium">{{ formatDate(selectedStudent.pkl.mulai) }} - {{ formatDate(selectedStudent.pkl.selesai) }}</p>
                </div>
                
                <div>
                  <p class="text-sm text-gray-500 mb-1">Status</p>
                  <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                    Aktif PKL
                  </span>
                </div>
              </div>
            </div>
            
            <div class="border-t border-gray-200 pt-4">
              <h4 class="font-semibold text-gray-900 mb-3">Detail Industri</h4>
              
              <div class="space-y-3">
                <div>
                  <p class="text-sm text-gray-500 mb-1">Nama Industri</p>
                  <p class="font-medium">{{ selectedStudent.pkl.industri }}</p>
                </div>
                
                <div v-if="selectedStudent.pkl.industri_detail">
                  <div>
                    <p class="text-sm text-gray-500 mb-1">Bidang Usaha</p>
                    <p class="font-medium">{{ selectedStudent.pkl.industri_detail.bidang_usaha }}</p>
                  </div>
                  
                  <div>
                    <p class="text-sm text-gray-500 mb-1">Alamat</p>
                    <p class="font-medium">{{ selectedStudent.pkl.industri_detail.alamat }}</p>
                  </div>
                  
                  <div>
                    <p class="text-sm text-gray-500 mb-1">Kontak</p>
                    <p class="font-medium">{{ selectedStudent.pkl.industri_detail.kontak }}</p>
                  </div>
                  
                  <div v-if="selectedStudent.pkl.industri_detail.website">
                    <p class="text-sm text-gray-500 mb-1">Website</p>
                    <a 
                      :href="formatWebsiteUrl(selectedStudent.pkl.industri_detail.website)" 
                      target="_blank"
                      class="text-green-600 hover:underline font-medium"
                    >
                      {{ selectedStudent.pkl.industri_detail.website }}
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="p-4 bg-gray-50 border-t border-gray-200 rounded-b-xl">
          <button
            @click="selectedStudent = null"
            class="w-full py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition-colors"
          >
            Tutup
          </button>
        </div>
      </div>
    </div>
  </GuruLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import GuruLayout from '@/Layouts/GuruLayout.vue'
import { 
  UserGroupIcon, 
  BuildingOfficeIcon, 
  CalendarIcon, 
  DocumentTextIcon, 
  EyeIcon,
  XMarkIcon,
  MagnifyingGlassIcon
} from '@heroicons/vue/24/outline'

const props = defineProps({
  students: {
    type: Array,
    default: () => []
  },
  stats: {
    type: Object,
    default: () => ({
      totalStudents: 0,
      totalIndustries: 0,
      activePkl: 0
    })
  }
})

const search = ref('')
const selectedStudent = ref(null)
const activeFilter = ref('all')

const filteredAndSortedStudents = computed(() => {
  let result = props.students
  
  if (search.value) {
    const searchLower = search.value.toLowerCase()
    result = result.filter(student =>
      student.nama?.toLowerCase().includes(searchLower) ||
      student.nis?.toLowerCase().includes(searchLower) ||
      (student.pkl?.industri && student.pkl.industri.toLowerCase().includes(searchLower))
    )
  }
  
  if (activeFilter.value === 'active') {
    result = result.filter(student => student.status_pkl)
  }
  
  return result.sort((a, b) => {
    if (a.status_pkl && !b.status_pkl) return -1
    if (!a.status_pkl && b.status_pkl) return 1
    return a.nama.localeCompare(b.nama)
  })
})

function showStudentDetail(student) {
  selectedStudent.value = student
}

function formatDate(dateString) {
  const options = { day: 'numeric', month: 'long', year: 'numeric' }
  return new Date(dateString).toLocaleDateString('id-ID', options)
}

function formatWebsiteUrl(website) {
  if (!website) return ''
  if (website.startsWith('http://') || website.startsWith('https://')) {
    return website
  }
  return `https://${website}`
}

function logout() {
  router.post('/logout')
}
</script>