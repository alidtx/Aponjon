<script setup>
const props = defineProps({
    src: {
        type: String,
        required: false,
        default: '',
    },
})
</script>

<template>
    <div
        v-if="props.src"
        class="grid h-8 w-8 place-content-center overflow-hidden rounded border p-0.5"
    >
        <img
            :src="props.src"
            class="w-full object-cover"
            alt="logo"
        />
    </div>
</template>

<style scoped></style>
