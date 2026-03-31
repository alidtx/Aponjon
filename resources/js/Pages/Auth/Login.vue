<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { ref, computed } from 'vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    login_field: '', 
    password: '',
    remember: false,
    login_type: 'email', 
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const showPassword = ref(false);
const loginType = ref('email'); 

const togglePasswordVisibility = () => {
    showPassword.value = !showPassword.value;
};

const inputType = computed(() => {
    return loginType.value === 'email' ? 'email' : 'tel'; 
});

const placeholder = computed(() => {
    return loginType.value === 'email'
        ? 'আপনার ইমেইল লিখুন'
        : 'আপনার ফোন নম্বর লিখুন';
});

const inputLabel = computed(() => {
    return loginType.value === 'email' ? 'ইমেইল' : 'ফোন নম্বর';
});

const inputName = computed(() => {
    return loginType.value === 'email' ? 'email' : 'phone';
});


const updateLoginField = () => {
    form.login_field = '';
};
</script>

<template>
    <GuestLayout>
        <Head title="লগইন" />
        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>
        <div class="text-center mb-2">
            <div class="flex items-center justify-center space-x-2 mb-4">
                <Link :href="route('home')">
                    <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
                </Link>
            </div>
            <h1 class="text-3xl font-bold text-dark">আপনার অ্যাকাউন্টে লগইন করুন</h1>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="py-4 text-center">
                <p class="py-1">অ্যাকাউন্টে লগইন করুন দিয়ে</p>
                <div class="flex justify-center gap-3">
                    <InputLabel>
                        <input 
                            type="radio" 
                            v-model="loginType" 
                            value="email"
                            @change="updateLoginField"
                            class="rounded-full border-4 border-gray-400 focus:ring-0 focus:ring-offset-0" 
                            name="login_type"
                        >
                        <span class="ms-2 text-sm text-gray-600">ইমেইল</span>
                    </InputLabel>
                    <InputLabel>
                        <input 
                            type="radio" 
                            v-model="loginType" 
                            value="phone"
                            @change="updateLoginField"
                            class="rounded-full border-4 border-gray-400 focus:ring-0 focus:ring-offset-0" 
                            name="login_type"
                        >
                        <span class="ms-2 text-sm text-gray-600">ফোন</span>
                    </InputLabel>
                </div>
            </div>
            
            <form @submit.prevent="submit">
                <div class="mb-4">
                    <InputLabel :for="inputName" :value="inputLabel" required />
                    <TextInput  
                        :id="inputName"
                        :type="inputType" 
                        class="mt-1 block w-full" 
                        v-model="form.login_field"
                        :placeholder="placeholder" 
                        autofocus 
                        :autocomplete="loginType === 'email' ? 'username' : 'tel'"
                    />
                    <InputError class="mt-2" :message="form.errors.login_field" />
                </div>

                <div class="mb-4">
                    <InputLabel for="password" value="পাসওয়ার্ড" required />
                    <div class="relative">
                        <TextInput 
                            id="password" 
                            :type="showPassword ? 'text' : 'password'"
                            class="mt-1 block w-full pr-10" 
                            v-model="form.password" 
                            placeholder="আপনার পাসওয়ার্ড লিখুন"
                            autocomplete="current-password" 
                        />
                        <button 
                            type="button" 
                            @click="togglePasswordVisibility"
                            class="absolute text-sm inset-y-0 right-0 pr-3 flex items-center mt-1"
                        >
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