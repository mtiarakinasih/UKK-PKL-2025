<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue';
import { EyeIcon, EyeSlashIcon } from '@heroicons/vue/24/solid';

defineProps({
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const showPassword = ref(false);

const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value;
};

const submit = () => {
  form.transform(data => ({
    ...data,
    remember: form.remember ? 'on' : '',
  })).post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <Head title="Log in" />

  <div
    class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50"
  >
    <div
      class="absolute top-0 left-0 w-full h-64 bg-gradient-to-r from-blue-700 to-indigo-700 rounded-b-[30%] opacity-90"
    ></div>

    <div
      class="w-full sm:max-w-md mt-24 px-6 py-8 bg-white shadow-2xl rounded-2xl z-10"
    >
      <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">
        Masuk ke Akun Anda
      </h1>
      <p class="text-center text-gray-600 mb-8">
        Silakan masukkan email dan password untuk melanjutkan
      </p>

      <div v-if="status" class="mb-4 font-medium text-sm text-blue-600">
        {{ status }}
      </div>

      <form @submit.prevent="submit" class="space-y-6">
        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
            Email
          </label>
          <TextInput
            id="email"
            v-model="form.email"
            type="email"
            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
            required
            autofocus
            autocomplete="username"
            placeholder="Masukkan email"
          />
          <InputError class="mt-2 text-xs" :message="form.errors.email" />
        </div>

        <!-- Password with eye toggle -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
            Password
          </label>
          <div class="relative">
            <input
              :type="showPassword ? 'text' : 'password'"
              id="password"
              v-model="form.password"
              class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 pr-10"
              required
              autocomplete="current-password"
              placeholder="Masukkan password"
            />
            <button
              type="button"
              @click="togglePasswordVisibility"
              class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 focus:outline-none"
              tabindex="-1"
            >
              <component :is="showPassword ? EyeSlashIcon : EyeIcon" class="w-5 h-5" />
            </button>
          </div>
          <InputError class="mt-2 text-xs" :message="form.errors.password" />
        </div>

        <!-- Remember -->
        <div class="flex items-center space-x-2">
          <input
            id="remember"
            type="checkbox"
            v-model="form.remember"
            class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
          />
          <label for="remember" class="text-sm text-gray-700 cursor-pointer">
            Ingat Saya
          </label>
        </div>

        <!-- Submit -->
        <div class="w-full flex justify-end">
          <PrimaryButton
            :disabled="form.processing"
            class="py-2.5 px-6 bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-semibold rounded-lg shadow-md transition duration-300"
            :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
          >
            Masuk
          </PrimaryButton>
        </div>
      </form>
    </div>
  </div>
</template>
