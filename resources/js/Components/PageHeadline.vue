<script setup>
const props = defineProps({
  title: {
    type: String,
    required: true
  },
  highlight: {
    type: String,
    required: false,
    default: ''
  },
  description: {
    type: String,
    required: true
  }
})
</script>

<template>
  <div class="text-center mb-8">
    <h1 class="text-4xl font-bold text-dark mb-4">
      {{ title }}
      <span v-if="highlight" class="text-primary max-sm">
        {{ highlight }}
      </span>
    </h1>

    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
      {{ description }}
    </p>
  </div>
</template>