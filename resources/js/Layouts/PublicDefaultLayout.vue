<script setup>
import NavBar from '@/Layouts/Partials/PublicResources/NavBar/Index.vue';
import Footer from '@/Layouts/Partials/PublicResources/Footer/Index.vue';

defineProps({
  canLogin: Boolean,
  canRegister: Boolean
})


</script>


<template>
    <NavBar 
    :canLogin="canLogin"
    :canRegister="canRegister"
    />
    <slot />
    <Footer />
</template>