<script setup>
import Navbar from '@/Layouts/Marketplace/NavBar/NavBar.vue';
import SideBar from './Marketplace/Partials/SideBar.vue';
import StatBar from './Marketplace/Partials/StatBar.vue';
import PageHeadline from '@/Components/PageHeadline.vue';
</script>

<template>
    <Navbar />
    <div class="max-w-7xl mx-auto px-4 py-8">
        <PageHeadline/>
        <StatBar />
        <div class="flex flex-col md:flex-row gap-8">
            <SideBar />
            <slot />
        </div>
    </div>
</template>