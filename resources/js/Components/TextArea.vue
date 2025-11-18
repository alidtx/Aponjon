<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <textarea
        class="border-gray-300 rounded-lg focus:ring-1 focus:ring-primary focus:border-transparent"
        rows="4"  v-model="model" ref="input">
        </textarea>
</template>
