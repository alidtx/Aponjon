<script setup>
import CustomerNav from '@/Layouts/Customer/NavBar/CustomerNav.vue';

const props = defineProps({
  user: {
    type: Object,
    required: true
  }
})
</script>


<template>
  <CustomerNav 
     :user="props.user"
  />
  <slot />
</template>