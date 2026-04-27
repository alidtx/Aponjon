<script setup>
import NavBar from './NavBar.vue';
import Footer from './Footer.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
</script>

<template>
    <NavBar>
         <a href="index.html" class="text-primary font-medium">
                <BaseIcon class="fas fa-arrow-left mr-2" /> হোম পেজে ফিরে যান
            </a>

    </NavBar>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <slot />
    </div>
    <Footer />
</template>