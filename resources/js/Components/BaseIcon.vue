<script setup>
defineProps({
    classes: {
        type: String,
        default: ''
    }
})
</script>


<template>
    <i :class="classes"></i>
</template>
