<script setup>
import NavBar from '@/Layouts/Partials/PublicResources/NavBar/Index.vue';
import Footer from '@/Layouts/Partials/PublicResources/Footer/Index.vue';

const props=defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
   user:{
      type:Object,
      required:true
    }
})


</script>


<template>
    <NavBar 
    :canLogin="canLogin"
    :canRegister="canRegister"
    :user="props.user"
    />
    <slot />
    <Footer />
</template>