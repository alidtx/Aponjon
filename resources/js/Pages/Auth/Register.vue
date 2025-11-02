<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

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
        <div class="grid grid-cols-1 gap-4 mb-8">
            <div
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
            <div
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
        <div id="registrationForm" class="hidden bg-white rounded-xl shadow-md p-6">
            <form id="unifiedRegistration">
                <input type="hidden" id="userRole" name="role" value="">

                <div class="mb-4">
                    <label class="block text-dark font-medium mb-2">পূর্ণ নাম <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="name"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary" required>
                </div>

                <div class="mb-4">
                    <label class="block text-dark font-medium mb-2">মোবাইল নম্বর <span
                            class="text-red-500">*</span></label>
                    <input type="tel" name="phone"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                        placeholder="01XXXXXXXXX" required>
                </div>

                <div class="mb-4">
                    <label class="block text-dark font-medium mb-2">ইমেইল (ঐচ্ছিক)</label>
                    <input type="email" name="email"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                        placeholder="your@email.com">
                </div>

                <div class="mb-6">
                    <label class="block text-dark font-medium mb-2">পাসওয়ার্ড <span
                            class="text-red-500">*</span></label>
                    <input type="password" name="password"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary" required>
                </div>

                <button type="submit"
                    class="w-full bg-primary text-white py-3 rounded-lg hover:bg-blue-700 font-medium">
                    অ্যাকাউন্ট তৈরি করুন
                </button>
            </form>

            <div class="mt-4 text-center">
                <p class="text-gray-600">ইতিমধ্যে অ্যাকাউন্ট আছে?
                    <a href="login.html" class="text-primary font-medium">লগইন করুন</a>
                </p>
            </div>
        </div>
    </GuestLayout>
</template>
