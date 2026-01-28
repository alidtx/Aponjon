<script setup>
defineProps({
    classes: {
        type: String,
        default: ''
    }
})
</script>


<template>
    <p :class="classes">
        <slot />
    </p>
</template>
