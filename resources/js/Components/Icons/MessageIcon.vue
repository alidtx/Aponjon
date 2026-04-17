<script setup>
defineProps({
  active: Boolean,
  count: {
    type: Number,
    default: 1
  }
})
</script>

<template>
  <div class="relative inline-flex">
    <svg xmlns="http://www.w3.org/2000/svg"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor"
         stroke-width="1.5"
         :class="['h-5 w-5 transition', active ? 'text-white' : 'text-violet-400']">

      <path stroke-linecap="round" stroke-linejoin="round"
            d="M2.25 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25-4.03 8.25-9 8.25a9.77 9.77 0 01-3.338-.57L3 21l1.32-3.96A8.06 8.06 0 012.25 12z" />
    </svg>
    <span
      v-if="count > 0"
      class="absolute -top-1 -right-1 min-w-[16px] h-4 px-1 flex items-center justify-center text-[10px] font-bold text-white bg-red-500 rounded-full">
      {{ count > 99 ? '99+' : count }}
    </span>
  </div>
</template>