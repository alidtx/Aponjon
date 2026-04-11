<script setup>
import TaskerNav from '@/Layouts/Tasker/NavBar/Nav.vue';
import Footer from './Partials/Footer.vue';

</script>


<template>
  <TaskerNav/>
  <div class="max-w-7xl mx-auto px-4 py-8">
  <slot />
  <Footer/>
  </div>
</template>