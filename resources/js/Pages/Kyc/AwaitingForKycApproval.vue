<script setup>
import AuthenticatedBaseLayout from '@/Layouts/AuthenticatedBaseLayout.vue';
import { Head } from '@inertiajs/vue3';
import LogOutIcon from '@/Components/Icons/LogOutIcon.vue';

const menuItems = [
    {
        label: 'লগআউট',
        route: route('logout'),
        icon: LogOutIcon,
        method: 'post',
        as: 'button',
        danger: true
    }
];
</script>

<template>
    <AuthenticatedBaseLayout :items="menuItems" :show-chat="false" :show-notifications="false">
        <Head title="অপেক্ষমাণ অনুমোদন" />

        <div class="max-w-7xl mx-auto px-4 py-12 w-full">
            <div class="min-h-[60vh] flex items-center justify-center">
                <div class="bg-white p-8 rounded shadow-md text-center max-w-xl w-full">
                    <h1 class="text-2xl font-bold mb-4">আপনার প্রোফাইলটি অনুমোদনের অপেক্ষায় রয়েছে</h1>
                    <p class="text-gray-600 mb-6">
                        আমরা আপনার প্রোফাইলটি যাচাই করছি এবং শীঘ্রই আপনাকে জানাবো। ধৈর্য ধরার জন্য ধন্যবাদ!
                    </p>
                    <a href="/" class="text-primary font-medium">হোম পেজে ফিরে যান</a>
                </div>
            </div>
        </div>
    </AuthenticatedBaseLayout>
</template>
