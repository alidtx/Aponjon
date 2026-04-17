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
       :class="['h-5 w-5', active ? 'text-white' : 'text-red-500']">
    <path stroke-linecap="round" stroke-linejoin="round"
          d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M18 12l3-3m0 0l-3-3m3 3H9" />
  </svg>
</template>