<script setup>
import NavBar from './NavBar.vue';
import Footer from './Partials/Footer.vue';
import SideBar from '@/Pages/Task/Partials/SideBar.vue';
</script>


<template>  
<div class="min-h-screen flex flex-col">
    
    <!-- Navbar -->
    <NavBar />

    <!-- Main Content -->
    <div class="flex-1 max-w-7xl mx-auto px-4 py-8 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <SideBar />
            <slot />
        </div>
    </div>

    <!-- Footer -->
    <Footer />

</div>

  
</template>