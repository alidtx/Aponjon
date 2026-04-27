<script setup>
import NavBar from './NavBar.vue';
import Footer from './Footer.vue';
</script>

<template>
    <NavBar>
        <div class="flex justify-between items-center py-4">
            <div class="flex items-center space-x-2">
                <Link :href="route('home')">
                <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
                </Link>
            </div>
            <a href="index.html" class="text-primary font-medium">
                <BaseIcon class="fas fa-arrow-left mr-2" /> হোম পেজে ফিরে যান
            </a>
        </div>

    </NavBar>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <slot />
    </div>
    <Footer />
</template>