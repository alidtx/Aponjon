<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <Link :href="route('home')">
                <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
                </Link>
                <div class="flex items-center space-x-4">
                    <a href="post-task.html" class="bg-accent text-white px-4 py-2 rounded-lg hover:bg-orange-600">
                        <i class="fas fa-plus mr-2"></i>টাস্ক পোস্ট করুন
                    </a>
                    <a href="tasker-dashboard.html" class="text-dark hover:text-primary">
                        টাস্কার হোন
                    </a>
                </div>
            </div>
        </div>
    </nav>
</template>