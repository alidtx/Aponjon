<script setup>
import { onMounted, ref, computed } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const props = defineProps({
    readonly: {
        type: Boolean,
        default: false
    },
    disabled: {
        type: Boolean,
        default: false
    }
});

const input = ref(null);

const focusClasses = computed(() => {
    if (props.readonly || props.disabled) {
        return 'focus:outline-none focus:ring-0 focus:border-gray-300';
    }
    return 'focus:ring-1 focus:ring-primary focus:border-transparent';
});

onMounted(() => {
    if (!props.readonly && !props.disabled && input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => {
    if (!props.readonly && !props.disabled) {
        input.value.focus();
    }
}});
</script>

<template>
    <input
        :class="[
            'border-gray-300 rounded-lg',
            focusClasses,
            {
                'bg-gray-50 cursor-not-allowed': readonly,
                'bg-gray-100 cursor-not-allowed opacity-75': disabled
            }
        ]"
        v-model="model"
        ref="input"
        :readonly="readonly"
        :disabled="disabled"
    />
</template>