<script setup>
import NavBar from './Partials/Nav/Tasker.vue';
import Footer from './Partials/Footer.vue';
</script>

<template>
    <NavBar />
    <div class="max-w-7xl mx-auto px-4 py-8">
        <slot />
    </div>
    <Footer />
</template>