<script setup>
import { defineProps, defineEmits } from 'vue'

const props = defineProps({
  modelValue: {
    type: [String, Number, null],
    default: null
  },
  options: {
    type: Array,
    required: true
  },
   defaultVal: {
    type: Array,
    required: true
  },
  className: {
    type: String,
    default: 'border-gray-300 rounded-lg focus:ring-1 focus:ring-primary focus:border-transparent'
  }
})

const emit = defineEmits(['update:modelValue'])

const updateValue = (e) => {
  emit('update:modelValue', e.target.value)
}
</script>

<template>
  <select
    :value="modelValue"
    @change="updateValue"
    :class="className"
  >
    <option value="">{{ defaultVal }}</option>
    <option
      v-for="(opt, index) in options"
      :key="index"
      :value="opt.value"
    >
      {{ opt.label }}
    </option>
  </select>
</template>
