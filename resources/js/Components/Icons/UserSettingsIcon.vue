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

    <path stroke-linecap="round"
          stroke-linejoin="round"
          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.591 1.06c1.527-.94 3.31.842 2.37 2.37a1.724 1.724 0 001.06 2.59c1.756.427 1.756 2.925 0 3.352a1.724 1.724 0 00-1.06 2.591c.94 1.528-.843 3.31-2.37 2.37a1.724 1.724 0 00-2.59 1.06c-.427 1.756-2.925 1.756-3.352 0a1.724 1.724 0 00-2.591-1.06c-1.528.94-3.31-.843-2.37-2.37a1.724 1.724 0 00-1.06-2.59c-1.756-.427-1.756-2.925 0-3.352a1.724 1.724 0 001.06-2.591c-.94-1.528.843-3.31 2.37-2.37.996.608 2.296.07 2.591-1.06z" />

    <path stroke-linecap="round"
          stroke-linejoin="round"
          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />

  </svg>
</template>