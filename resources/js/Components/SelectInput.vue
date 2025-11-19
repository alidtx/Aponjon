<script setup>
import { defineProps, defineEmits } from 'vue'

const props = defineProps({
  modelValue: {
    type: [String, Number, null],
    default: ''
  },
  options: {
    type: Array,
    required: true
  },
  defaultVal: {
    type: String,
    required: true
  },
  className: {
    type: String,
    default:
      'border-gray-300 rounded-lg focus:ring-1 focus:ring-primary focus:border-transparent'
  },

  labelKey: {
    type: String,
    default: 'name'
  },
  valueKey: {
    type: String,
    default: 'value'
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
    :class="[className, modelValue === '' ? 'text-gray-500' : 'text-black']"
  >
    <option value="" disabled>{{ defaultVal }}</option>

    <option
      v-for="(opt, index) in options"
      :key="index"
      :value="opt[valueKey]"   
      class="text-black"
    >
      {{ opt[labelKey] }}      
    </option>
  </select>
</template>

