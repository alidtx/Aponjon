<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>



<template>
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-2">
                    <Link :href="route('home')">
                    <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
                    </Link>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="marketplace.html" class="text-dark hover:text-primary">টাস্কস</a>
                    <a href="post-task.html" class="bg-accent text-white px-4 py-2 rounded-lg hover:bg-orange-600">
                        টাস্ক পোস্ট করুন
                    </a>
                    <div class="relative group">
                        <button class="flex items-center space-x-2">
                            <img src="https://via.placeholder.com/40" alt="Profile" class="w-8 h-8 rounded-full">
                            <span class="text-dark">রহিমা</span>
                            <i class="fas fa-chevron-down text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>