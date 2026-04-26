<script setup>
defineProps({
  active: Boolean
})
</script>

<template>
  <svg xmlns="http://www.w3.org/2000/svg"
       viewBox="0 0 24 24"
       fill="none"
       stroke="currentColor"
       stroke-width="1.8"
       stroke-linecap="round"
       stroke-linejoin="round"
       :class="['h-7 w-7', active ? 'text-white' : 'text-primary']">
    <path d="M12 2.75v2.5M12 18.75v2.5M4.93 4.93l1.77 1.77M17.3 17.3l1.77 1.77M2.75 12h2.5M18.75 12h2.5M4.93 19.07l1.77-1.77M17.3 6.7l1.77-1.77" />
    <circle cx="12" cy="12" r="3.5" />
  </svg>
</template>