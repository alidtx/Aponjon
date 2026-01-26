<script setup>
import Navbar from '@/Layouts/Marketplace/NavBar/NavBar.vue';
import Footer from './Marketplace/Footer/Footer.vue';
</script>

<template>
    <Navbar />
    <div class="max-w-7xl mx-auto px-4 py-8">
       <slot />
    </div>
    <Footer/>
</template>