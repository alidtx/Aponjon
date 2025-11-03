<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
</script>

<template>
    <GuestLayout>
        <Head title="ওটিপি" />
        <div class="text-center mb-2">
            <div class="flex items-center justify-center space-x-2 mb-4">
                <Link :href="route('home')">
                <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
                </Link>
            </div>
           <h1 class="text-3xl font-bold text-dark">ওটিপি যাচাইকরণ</h1>
           <p class="text-gray-600 mt-2">আপনার মোবাইলে পাঠানো ৬-সংখ্যার কোডটি লিখুন</p>
        </div>

         <div class="bg-white rounded-xl shadow-md p-6">
                <div class="mb-6 text-center">
                    <div class="flex items-center justify-center mb-4">
                        <i class="fas fa-mobile-alt text-4xl text-primary"></i>
                    </div>
                    <p class="text-gray-700">আমরা <span class="font-semibold">+8801XXXXXXXXX</span> নম্বরে একটি ওটিপি পাঠিয়েছি</p>
                </div>

                <form id="otpForm">
                    <div class="mb-6">
                        <label class="block text-dark font-medium mb-3 text-center">৬-সংখ্যার ওটিপি কোড</label>
                        <div class="flex justify-between space-x-2 px-4">
                            <input type="text" maxlength="1" class="w-full h-10 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:ring-1 focus:ring-primary focus:border-transparent">
                            <input type="text" maxlength="1" class="w-full h-10 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:ring-1 focus:ring-primary focus:border-transparent">
                            <input type="text" maxlength="1" class="w-full h-10 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:ring-1 focus:ring-primary focus:border-transparent">
                            <input type="text" maxlength="1" class="w-full h-10 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:ring-1 focus:ring-primary focus:border-transparent">
                            <input type="text" maxlength="1" class="w-full h-10 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:ring-1 focus:ring-primary focus:border-transparent">
                            <input type="text" maxlength="1" class="w-full h-10 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:ring-1 focus:ring-primary focus:border-transparent">
                        </div>
                    </div>

                    <div class="mb-6 text-center">
                        <p class="text-gray-600">কোড পাননি? <span id="countdown" class="text-primary font-medium">02:00</span> পরে আবার চেষ্টা করুন</p>
                        <button type="button" id="resendBtn" class="text-primary font-medium hover:underline mt-2 hidden">কোড পুনরায় পাঠান</button>
                    </div>

                    <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg hover:bg-blue-700 font-medium transition duration-200">
                        যাচাই করুন
                    </button>
                </form>

                <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                    <p class="text-gray-600">ভুল নম্বর ব্যবহার করেছেন? 
                        <a href="login.html" class="text-primary font-medium hover:underline">ফিরে যান</a>
                    </p>
                </div>
            </div>
    </GuestLayout>
</template>