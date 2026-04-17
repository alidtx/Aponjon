<script setup>
import NavBar from './NavBar.vue';

const props = defineProps({
  user: {
    type: Object,
    required: false,
    default:null
  }
})
</script>


<template>
  <NavBar 
     :user="props.user"
  />
  <slot />
</template>