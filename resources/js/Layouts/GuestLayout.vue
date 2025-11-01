<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center py-12">
        <div class="max-w-md w-full">
          <slot/>
        </div>
    </div>
    </div>
</template>
