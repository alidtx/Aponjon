<script setup>
import HomeNav from './HomeNav.vue';
import HomeFooter from './HomeFooter.vue';

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
    <HomeNav
    :canLogin="canLogin"
    :canRegister="canRegister"
    :user="props.user"
    />
    <slot />
    <HomeFooter />
</template>