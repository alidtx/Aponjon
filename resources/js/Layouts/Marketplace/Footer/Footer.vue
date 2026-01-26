<script setup>
import { usePage } from '@inertiajs/vue3';

const page = usePage()
const siteConfig = page.props.siteConfig
</script>


<template>
   <div class="max-w-6xl mx-auto py-5  border-t border-gray-300">
        <div class="text-center text-gray-600 text-sm">
            <p>© {{ new Date().getFullYear() }} {{siteConfig.name}}। সর্বস্বত্ব সংরক্ষিত।</p>
            <p class="mt-2">{{ siteConfig.scam_policy }}</p>
        </div>
    </div>
</template>