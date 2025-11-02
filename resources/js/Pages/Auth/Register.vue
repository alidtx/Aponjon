<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { ref } from 'vue';

const form = useForm({
    name: '',
    identifier: '',
    password: '',
    password_confirmation: '',
    role: '', 
});

const showRegistrationForm = ref(false); 
const selectedRole = ref(''); 

const FormRoleToggle = (role) => {
    showRegistrationForm.value = true;
    selectedRole.value = role;
    form.role = role; 
};

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="রেজিস্টার" />
        <div class="text-center mb-2">
            <div class="flex items-center justify-center space-x-2 mb-4">
                <Link :href="route('home')">
                    <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
                </Link>
            </div>
            <h1 class="text-3xl font-bold text-dark">একটি অ্যাকাউন্ট তৈরি করুন</h1>
            <p class="text-gray-600 mt-2">আপনি কীভাবে <span class="text-dark">আপ</span><span
                    class="text-primary">জন</span> ব্যবহার করতে চান?</p>
        </div>

        
        <div v-if="!showRegistrationForm" class="grid grid-cols-1 gap-4 mb-8">
            <div @click="FormRoleToggle('customer')"
                class="role-card border-2 border-gray-200 rounded-xl p-6 hover:border-primary cursor-pointer transition-all bg-white">
                <div class="flex items-start">
                    <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-user text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-dark mb-2">সেবা নিন</h3>
                        <p class="text-gray-600 mb-3">আমি কাজ করাতে চাই। টাস্ক পোস্ট করে সেবা নিতে চাই।</p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li class="flex items-center">
                                <i class="fas fa-check text-success mr-2"></i>
                                টাস্ক পোস্ট করুন
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-success mr-2"></i>
                                টাস্কার নির্বাচন করুন
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-success mr-2"></i>
                                সুরক্ষিত পেমেন্ট
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div @click="FormRoleToggle('tasker')"
                class="role-card border-2 border-gray-200 rounded-xl p-6 hover:border-primary cursor-pointer transition-all bg-white">
                <div class="flex items-start">
                    <div class="w-12 h-12 bg-accent rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-tools text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-dark mb-2">টাস্কার হোন</h3>
                        <p class="text-gray-600 mb-3">আমি কাজ করতে চাই। আমার দক্ষতা দিয়ে আয় করতে চাই।</p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li class="flex items-center">
                                <i class="fas fa-check text-success mr-2"></i>
                                কাজ খুঁজুন
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-success mr-2"></i>
                                আয় করুন
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-success mr-2"></i>
                                রেটিং বাড়ান
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <div v-if="showRegistrationForm" class="bg-white rounded-xl shadow-md p-6">
            
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3"
                            :class="selectedRole === 'customer' ? 'bg-primary' : 'bg-accent'">
                            <i class="fas text-white text-sm"
                                :class="selectedRole === 'customer' ? 'fa-user' : 'fa-tools'"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-dark">
                                {{ selectedRole === 'customer' ? 'সেবা নিন' : 'টাস্কার হোন' }}
                            </h3>
                            <p class="text-sm text-gray-600">
                                {{ selectedRole === 'customer' ? 'আপনি সেবা গ্রহণকারী হিসেবে রেজিস্টার করছেন' : 'আপনি টাস্কার হিসেবে রেজিস্টার করছেন' }}
                            </p>
                        </div>
                    </div>
                    <button @click="showRegistrationForm = false; selectedRole = ''; form.role = '';"
                        class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <form @submit.prevent="submit">
                
                <input type="hidden" v-model="form.role">

                <div class="mb-4">
                    <InputLabel for="name" value="পূর্ণ নাম" required/>
                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name"  autofocus
                        autocomplete="name" />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mb-4">
                    <InputLabel for="email" value="মোবাইল নম্বর বা ইমেইল " required/>
                    <TextInput id="email" type="text" class="mt-1 block w-full" v-model="form.identifier"
                        autocomplete="username"  />
                    <InputError class="mt-2" :message="form.errors.identifier" />
                </div>

                <div class="mb-4">
                    <InputLabel for="password" value="পাসওয়ার্ড" required/>
                    <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" 
                        autocomplete="new-password" />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="mb-6">
                    <InputLabel for="password_confirmation" value="পাসওয়ার্ড নিশ্চিত করুন" required/>
                    <TextInput id="password_confirmation" type="password" class="mt-1 block w-full"
                        v-model="form.password_confirmation"  autocomplete="new-password" />
                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        অ্যাকাউন্ট তৈরি করুন
                    </PrimaryButton>
                </div>
            </form>

            <div class="mt-4 text-center">
                <p class="text-gray-600">ইতিমধ্যে অ্যাকাউন্ট আছে?
                    <Link :href="route('login')" class="text-primary font-medium">লগইন করুন</Link>
                </p>
            </div>
        </div>
    </GuestLayout>
</template>