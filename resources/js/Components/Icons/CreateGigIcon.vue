<script setup>
defineProps({
  active: Boolean
})
</script>

<template>
  <svg xmlns="http://www.w3.org/2000/svg"
       fill="none"
       viewBox="0 0 24 24"
       stroke="currentColor"
       stroke-width="1.5"
       :class="['h-7 w-7', active ? 'text-white' : 'text-primary']">

    <!-- Briefcase -->
    <path stroke-linecap="round" stroke-linejoin="round"
          d="M9 6V5a3 3 0 016 0v1m-9 4h12m-13 0h14a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2z" />

    <!-- Plus -->
    <path stroke-linecap="round" stroke-linejoin="round"
          d="M12 11v4m2-2h-4" />
  </svg>
</template>