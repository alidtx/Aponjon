<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { ref } from 'vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const showPassword = ref(false);

const togglePasswordVisibility = () => {
    showPassword.value = !showPassword.value;
};
</script>

<template>
    <GuestLayout>

        <Head title="লগইন" />
        <div class="text-center mb-8">
            <div class="flex items-center justify-center space-x-2 mb-4">
                <Link :href="route('home')">
                <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
                </Link>
            </div>
            <h1 class="text-3xl font-bold text-dark">আপনার অ্যাকাউন্টে লগইন করুন</h1>

            <div class="bg-white rounded-xl shadow-md p-6">
                <form @submit.prevent="submit">
                    <div class="mb-4">
                        <InputLabel for="email" value="মোবাইল নম্বর বা ইমেইল" required />
                        <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                            placeholder="01XXXXXXXXX বা your@email.com" autofocus autocomplete="username" />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mb-4">
                        <InputLabel for="password" value="পাসওয়ার্ড" required />
                        <div class="relative">
                            <TextInput id="password" :type="showPassword ? 'text' : 'password'"
                                class="mt-1 block w-full pr-10" v-model="form.password" required
                                autocomplete="current-password" />
                            <button type="button" @click="togglePasswordVisibility"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center mt-1">
                                <i :class="showPassword ? 'far fa-eye-slash text-gray-600' : 'far fa-eye text-gray-400'"
                                    class="transition-colors duration-200"></i>
                            </button>
                        </div>
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <label class="flex items-center">
                                <Checkbox name="remember" v-model:checked="form.remember" />
                                <span class="ms-2 text-sm text-gray-600">আমাকে মনে রাখুন</span>
                            </label>
                        </div>
                        <Link v-if="canResetPassword" :href="route('password.request')"
                            class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        পাসওয়ার্ড ভুলে গেছেন?
                        </Link>
                    </div>

                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        লগইন করুন
                    </PrimaryButton>
                </form>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <p class="text-gray-600 text-center">অ্যাকাউন্ট নেই?
                        <Link :href="route('register')" class="text-primary font-medium hover:underline">
                        একটি অ্যাকাউন্ট তৈরি করুন
                        </Link>
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-gray-50 text-gray-500">অথবা সোশ্যাল মিডিয়া দিয়ে লগইন করুন</span>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-2 gap-3">
                <button type="button"
                    class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition duration-200">
                    <i class="fab fa-google text-red-500"></i>
                    <span class="ml-2">গুগল</span>
                </button>
                <button type="button"
                    class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition duration-200">
                    <i class="fab fa-facebook text-blue-600"></i>
                    <span class="ml-2">ফেসবুক</span>
                </button>
            </div>
        </div>
    </GuestLayout>
</template>

<style scoped>
.text-dark {
    color: #1f2937;
}

.text-primary {
    color: #3b82f6;
}

.bg-gray-50 {
    background-color: #f9fafb;
}
</style>