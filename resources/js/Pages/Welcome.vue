<template>
  <div class="landing-page">
    <nav class="bg-white/90 backdrop-blur-sm fixed w-full z-50 shadow-sm">
      <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <div class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 text-transparent bg-clip-text">PKL</div>
          </div>
          <div class="flex items-center space-x-4">
            <a href="/login" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Masuk</a>
            <a href="/register" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-5 rounded-full text-sm font-medium transition-colors shadow-sm hover:shadow-md">Daftar</a>
          </div>
        </div>
      </div>
    </nav>

    <section class="pt-36 pb-24 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 overflow-hidden">
      <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row items-center">
          <div class="md:w-1/2 md:pr-12">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-800 leading-tight mb-6">
              <span class="bg-gradient-to-r from-blue-600 to-indigo-600 text-transparent bg-clip-text">Catat Lokasi</span> PKL dengan Mudah
            </h1>
            <p class="text-lg text-gray-600 mb-10 leading-relaxed">
              Solusi untuk siswa yang ingin mendaftarkan tempat PKL dan guru memantau lokasi PKL siswa.
            </p>
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
              <a href="/register" class="bg-blue-600 hover:bg-blue-700 text-white py-3 px-8 rounded-full font-medium text-center transition-colors shadow-md hover:shadow-lg">
                Mulai Sekarang
              </a>
              <a href="#features" class="border border-blue-600 text-blue-600 hover:bg-blue-50 py-3 px-8 rounded-full font-medium text-center transition-colors">
                Lihat Fitur
              </a>
            </div>
          </div>
          <div class="md:w-1/2 mt-12 md:mt-0 relative">
            <div class="absolute -top-16 -right-16 w-64 h-64 bg-blue-100 rounded-full opacity-50 blur-3xl"></div>
            <div class="absolute -bottom-8 -left-8 w-40 h-40 bg-purple-100 rounded-full opacity-50 blur-3xl"></div>
            
          </div>
        </div>
      </div>
    </section>

    <section id="features" class="py-24 bg-white relative">
      <div class="absolute top-0 inset-x-0 h-32 bg-gradient-to-b from-blue-50 to-white"></div>
      <div class="container mx-auto px-6 relative z-10">
        <div class="text-center mb-20">
          <span class="px-4 py-1 bg-blue-100 text-blue-600 rounded-full text-sm font-medium mb-4 inline-block">Fitur Utama</span>
          <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Fokus pada Pencatatan Lokasi PKL</h2>
          <p class="text-gray-600 max-w-2xl mx-auto text-lg">
            Platform yang dirancang untuk pencatatan lokasi PKL dan monitoring oleh guru
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
          <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-blue-200 group">
            <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-3 group-hover:text-blue-600 transition-colors">Pencatatan Lokasi PKL</h3>
            <p class="text-gray-600">
              Siswa dapat dengan mudah mencatat lokasi PKL mereka dan menambahkan industri baru jika belum terdaftar di sistem.
            </p>
          </div>

          <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-green-200 group">
            <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-green-600 transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-3 group-hover:text-green-600 transition-colors">Monitoring oleh Guru</h3>
            <p class="text-gray-600">
              Guru dapat memantau dengan mudah lokasi PKL seluruh siswa bimbingan.
            </p>
          </div>

          <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-purple-200 group">
            <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-purple-600 transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-3 group-hover:text-purple-600 transition-colors">Pendaftaran Industri</h3>
            <p class="text-gray-600">
              Siswa dapat menambahkan industri baru ke database jika lokasi PKL mereka belum terdaftar dalam sistem.
            </p>
          </div>
        </div>
      </div>
    </section>

    <section class="py-20 bg-gradient-to-r from-blue-600 to-indigo-700 relative overflow-hidden">
      <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-10 -right-10 w-72 h-72 bg-white rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-72 h-72 bg-white rounded-full"></div>
      </div>
      <div class="container mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center max-w-4xl mx-auto">
          <div class="p-6 bg-white/10 backdrop-blur-sm rounded-xl">
            <p class="text-5xl font-bold text-white mb-2">{{ stats.totalStudents }}+</p>
            <p class="text-blue-100 text-lg">Siswa Aktif</p>
          </div>
          <div class="p-6 bg-white/10 backdrop-blur-sm rounded-xl">
            <p class="text-5xl font-bold text-white mb-2">{{ stats.totalIndustries }}+</p>
            <p class="text-blue-100 text-lg">Industri</p>
          </div>
          <div class="p-6 bg-white/10 backdrop-blur-sm rounded-xl">
            <p class="text-5xl font-bold text-white mb-2">{{ stats.satisfactionRate }}%</p>
            <p class="text-blue-100 text-lg">Tingkat Kepuasan</p>
          </div>
        </div>
      </div>
    </section>

    <section class="py-24 bg-white">
      <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl overflow-hidden shadow-2xl">
          <div class="px-8 py-16 md:p-16 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Siap Mulai Mengelola PKL?</h2>
            <p class="text-xl text-blue-100 mb-10 max-w-3xl mx-auto">
              Bergabunglah untuk kemudahan pencatatan dan monitoring lokasi PKL.
            </p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
              <a href="/register" class="bg-white text-blue-700 hover:bg-blue-50 py-3 px-8 rounded-full font-semibold shadow-lg transition-colors">
                Daftar Sekarang
              </a>
              <a href="#features" class="border-2 border-white text-white hover:bg-white hover:text-blue-700 py-3 px-8 rounded-full font-semibold transition-colors">
                Pelajari Fitur
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <footer class="bg-gray-50 border-t border-gray-100">
      <div class="container mx-auto px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
          <div class="col-span-1 md:col-span-2">
            <div class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 text-transparent bg-clip-text mb-4">PKL</div>
            <p class="text-gray-600 mb-6 max-w-md">
              Solusi untuk siswa mendaftarkan tempat PKL dan guru memantau lokasi PKL siswa.
            </p>
            <div class="flex space-x-4">
              <a href="#" class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>
                </svg>
              </a>
              <a href="#" class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm6.066 9.645c.183 4.04-2.83 8.544-8.164 8.544-1.622 0-3.131-.476-4.402-1.291 1.524.18 3.045-.244 4.252-1.189-1.256-.023-2.317-.854-2.684-1.995.451.086.895.061 1.298-.049-1.381-.278-2.335-1.522-2.304-2.853.388.215.83.344 1.301.359-1.279-.855-1.641-2.544-.889-3.835 1.416 1.738 3.533 2.881 5.92 3.001-.419-1.796.944-3.527 2.799-3.527.825 0 1.572.349 2.096.907.654-.128 1.27-.368 1.824-.697-.215.671-.67 1.233-1.263 1.589.581-.07 1.135-.224 1.649-.453-.384.578-.87 1.084-1.433 1.489z"/>
                </svg>
              </a>
              <a href="#" class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                </svg>
              </a>
            </div>
          </div>
        </div>
        
        <div class="border-t border-gray-200 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
          <p class="text-gray-600 text-sm mb-4 md:mb-0">© 2025 barrdisini:3</p>
          <div class="flex space-x-6">
            <a href="#" class="text-gray-500 hover:text-gray-800 text-sm">Kebijakan Privasi</a>
            <a href="#" class="text-gray-500 hover:text-gray-800 text-sm">Syarat & Ketentuan</a>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
defineProps({
  stats: {
    type: Object,
    default: () => ({
      totalStudents: 0,
      totalIndustries: 0,
      satisfactionRate: 97
    })
  }
});
</script>

<style>
.landing-page {
  scroll-behavior: smooth;
}
</style>