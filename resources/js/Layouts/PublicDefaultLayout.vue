<script setup>
     import NavBar from '@/Layouts/Partials/PublicResources/NavBar/Index.vue';
     import Footer from '@/Layouts/Partials/PublicResources/Footer/Index.vue';
</script>


<template>
    <NavBar/>
          <slot/>
    <Footer/>
</template>