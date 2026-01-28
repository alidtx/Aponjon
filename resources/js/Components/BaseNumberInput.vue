<script setup>
import { ref, onMounted } from 'vue';

const model = defineModel({
  type: [Number, String], 
  required: true,
});

const input = ref(null);

onMounted(() => {
  if (input.value && input.value.hasAttribute('autofocus')) {
    input.value.focus();
  }
});

defineExpose({
  focus: () => input.value && input.value.focus(),
});
</script>

<template>
  <input
    type="number"
    v-model="model"
    ref="input"
    class="border-gray-300 rounded-lg focus:ring-1 focus:ring-primary focus:border-transparent"
  />
</template>
