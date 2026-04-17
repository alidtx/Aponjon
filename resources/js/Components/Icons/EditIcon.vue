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
       :class="['h-5 w-5', active ? 'text-white' : 'text-violet-400']">
    <path stroke-linecap="round" stroke-linejoin="round"
          d="M16.862 3.487a2.1 2.1 0 113.02 2.92L9.75 16.5 6 18l1.5-3.75 9.362-10.763z" />
  </svg>
</template>