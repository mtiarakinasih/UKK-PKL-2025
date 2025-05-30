<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
    email: '',
    nis: '',
    gender: 'L',
    alamat: '',
    kontak: '',
    role: 'siswa',
    password: '',
    password_confirmation: '',
    terms: false,
});

const emailError = ref('');
const isValidEmail = computed(() => {
    if (!form.email) return true;
    
    const isValid = form.email.toLowerCase().endsWith('@siswasija.com');
    
    emailError.value = isValid ? '' : 'Email harus menggunakan domain @siswasija.com';
    return isValid;
});

const submit = () => {
    if (!isValidEmail.value) {
        return;
    }
    
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Register" />

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-green-50 via-teal-50 to-blue-50">
        <div class="absolute top-0 left-0 w-full h-64 bg-gradient-to-r from-green-600 to-teal-600 rounded-b-[30%] opacity-90"></div>
        
        <div class="w-full sm:max-w-2xl mt-24 px-6 py-8 bg-white shadow-2xl rounded-2xl z-10">
            
            
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Buat Akun Baru</h1>
            <p class="text-center text-gray-600 mb-8">Mulai perjalanan PKL Anda dengan membuat akun</p>

            <form @submit.prevent="submit" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <TextInput
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Masukkan nama lengkap"
                        />
                        <InputError class="mt-1 text-xs" :message="form.errors.name" />
                    </div>

                    <div>
                        <label for="nis" class="block text-sm font-medium text-gray-700 mb-1">NIS (Nomor Induk Siswa)</label>
                        <TextInput
                            id="nis"
                            v-model="form.nis"
                            type="text"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200"
                            required
                            placeholder="Contoh: 202412345"
                        />
                        <InputError class="mt-1 text-xs" :message="form.errors.nis" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                        <div class="flex space-x-4">
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input
                                    type="radio"
                                    v-model="form.gender"
                                    value="L"
                                    class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500"
                                >
                                <span class="text-gray-700">Laki-laki</span>
                            </label>
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input
                                    type="radio"
                                    v-model="form.gender"
                                    value="P"
                                    class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500"
                                >
                                <span class="text-gray-700">Perempuan</span>
                            </label>
                        </div>
                        <InputError class="mt-1 text-xs" :message="form.errors.gender" />
                    </div>

                    <div>
                        <label for="kontak" class="block text-sm font-medium text-gray-700 mb-1">Kontak (No. Telepon)</label>
                        <TextInput
                            id="kontak"
                            v-model="form.kontak"
                            type="text"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200"
                            required
                            placeholder="+62 812-3456-7890"
                        />
                        <InputError class="mt-1 text-xs" :message="form.errors.kontak" />
                    </div>
                </div>

                <div>
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea
                        id="alamat"
                        v-model="form.alamat"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 resize-none"
                        rows="2"
                        required
                        placeholder="Masukkan alamat lengkap"
                    ></textarea>
                    <InputError class="mt-1 text-xs" :message="form.errors.alamat" />
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <TextInput
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 pr-10"
                            :class="{'border-red-500 focus:border-red-500 focus:ring-red-200': !isValidEmail && form.email}"
                            required
                            autocomplete="username"
                            placeholder="email@siswasija.com"
                        />
                        <div v-if="form.email && !isValidEmail" 
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div v-if="form.email && isValidEmail" 
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-green-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <InputError class="mt-1 text-xs" :message="form.errors.email || emailError" />
                    <p class="mt-1 text-xs text-gray-500 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        Hanya email dengan domain @siswasija.com yang diizinkan
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <TextInput
                                id="password"
                                v-model="form.password"
                                type="password"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200"
                                required
                                autocomplete="new-password"
                                placeholder="Min. 8 karakter"
                            />
                        </div>
                        <InputError class="mt-1 text-xs" :message="form.errors.password" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                        <TextInput
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200"
                            required
                            autocomplete="new-password"
                            placeholder="Ulangi password"
                        />
                        <InputError class="mt-1 text-xs" :message="form.errors.password_confirmation" />
                    </div>
                </div>

                <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="flex items-start space-x-2">
                    <input 
                        id="terms" 
                        v-model="form.terms" 
                        type="checkbox" 
                        name="terms" 
                        required
                        class="h-4 w-4 mt-1 text-green-600 border-gray-300 rounded focus:ring-green-500" 
                    />
                    <div>
                        <label for="terms" class="text-sm text-gray-700">
                            I agree to the <a target="_blank" :href="route('terms.show')" class="text-green-600 hover:text-green-800 font-medium">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="text-green-600 hover:text-green-800 font-medium">Privacy Policy</a>
                        </label>
                        <InputError class="mt-1 text-xs" :message="form.errors.terms" />
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4">
                    <Link :href="route('login')" class="text-sm text-gray-600 hover:text-green-600 transition-colors">
                        Sudah punya akun? Login
                    </Link>

                    <button
                        type="submit"
                        class="w-full sm:w-auto py-2.5 px-6 bg-gradient-to-r from-green-500 to-teal-600 hover:from-green-600 hover:to-teal-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform hover:-translate-y-0.5"
                        :class="{ 'opacity-70 cursor-not-allowed': form.processing || !isValidEmail }"
                        :disabled="form.processing || !isValidEmail"
                    >
                        <div class="flex items-center justify-center">
                            <span>Daftar Sekarang</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

html, body {
  font-family: 'Poppins', sans-serif;
}

input, textarea, select, button {
  transition: all 0.2s ease-in-out;
}

input:focus-visible, textarea:focus-visible {
  outline: none;
}
</style>