<script setup>
defineProps({
  value: {
    type: String,
  },
  required: {
    type: Boolean,
    default: false,
  },
});
</script>

<template>
  <label class="block text-dark font-medium mb-2">
    <span v-if="value">
      {{ value }}
      <span v-if="required" class="text-red-500">*</span>
    </span>
    <span v-else>
      <slot />
      <span v-if="required" class="text-red-500">*</span>
    </span>
  </label>
</template>
