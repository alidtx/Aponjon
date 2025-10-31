<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import MenuItem from '@/Layouts/MenuItem.json';
</script>


<template>
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a v-for="(item, index) in MenuItem.HomeMenus" :key="index" :href="item.href"
                        class="text-dark hover:text-primary font-medium">
                        {{ item.name }}
                    </a>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    <button class="px-4 py-2 text-dark font-medium hover:text-primary">লগইন</button>
                    <button class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 font-medium">
                        রেজিস্টার
                    </button>
                    <button class="px-4 py-2 bg-accent text-white rounded-lg hover:bg-orange-600 font-medium">
                        টাস্কার হোন
                    </button>
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-dark">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </nav>
</template>