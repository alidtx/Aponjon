<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
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
                <a href="index.html" class="text-primary font-medium">
                    <BaseIcon class="fas fa-arrow-left mr-2"/>  হোম পেজে ফিরে যান
                </a>
            </div>
        </div>
    </nav>
</template>