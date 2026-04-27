<script setup>
import { usePage } from '@inertiajs/vue3';

const page = usePage()
const siteConfig = page.props.siteConfig
</script>


<template>
 <div class="py-5 max-w-6xl mx-auto border-t border-gray-300 w-full">
    <div class="px-4 text-center text-gray-600 text-sm">
        <p>© {{ new Date().getFullYear() }} {{siteConfig.name}}। সর্বস্বত্ব সংরক্ষিত।</p>
        <p class="mt-2">{{ siteConfig.scam_policy }}</p>
    </div>
</div>
</template>