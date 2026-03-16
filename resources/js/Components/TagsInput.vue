<script setup>
import { ref, watch, computed } from "vue"

const props = defineProps({
    modelValue: {
        type: Array,
        default: () => []
    },
    placeholder: {
        type: String,
        default: "Type and press enter"
    },
    maxTags: {
        type: Number,
        default: 5
    },
    maxTagLength: {
        type: Number,
        default: 25
    }
})

const emit = defineEmits(["update:modelValue"])

const input = ref("")
const tags = ref([...props.modelValue])

watch(tags, () => {
    emit("update:modelValue", tags.value)
}, { deep: true })

const addTag = () => {
    const value = input.value.trim()

    if (!value) return
    if (tags.value.length >= props.maxTags) {
        alert(`You cannot add more than ${props.maxTags} tags`)
        return
    }

    if (value.length > props.maxTagLength) {
        alert(`Tag cannot exceed ${props.maxTagLength} characters`)
        return
    }

    if (!tags.value.includes(value)) {
        tags.value.push(value)
    }

    input.value = ""
}

const removeTag = (index) => {
    tags.value.splice(index, 1)
}

const handleKey = (e) => {
    if (e.key === "Enter" || e.key === ",") {
        e.preventDefault()
        addTag()
    }

    if (e.key === "Backspace" && !input.value) {
        tags.value.pop()
    }
}

const remainingChars = computed(() => {
    return props.maxTagLength - input.value.length
})

const isNearLimit = computed(() => {
    return input.value.length >= props.maxTagLength - 5
})
</script>

<template>
    <div
        class="w-full border border-gray-300 rounded-lg px-2 py-1 flex flex-wrap items-center gap-2 focus:ring-2 focus-within:ring-primary">

        <span v-for="(tag, index) in tags" :key="index"
            class="flex items-center bg-gray-200 text-gray-800 text-sm px-2 py-1 rounded-md group relative"
            :title="tag.length > 20 ? tag : ''">
            <span class="max-w-[150px] truncate">{{ tag }}</span>
            <button type="button" @click="removeTag(index)" class="ml-2 text-gray-500 hover:text-red-500">
                ✕
            </button>
        </span>

        <div class="relative flex items-center">
            <input v-model="input" @keydown="handleKey"
                :placeholder="tags.length >= maxTags ? `৫টি দক্ষতা সর্বোচ্চ` : placeholder"
                :disabled="tags.length >= maxTags" :maxlength="maxTagLength"
                class="border-gray-300 rounded-lg focus:ring-1 focus:ring-primary focus:border-transparent pr-12"
                :class="{
                    'opacity-50 cursor-not-allowed': tags.length >= maxTags,
                    'border-yellow-300 focus:ring-yellow-300': isNearLimit && !tags.length >= maxTags
                }" />
            <span v-if="input.length > 0 && tags.length < maxTags" class="absolute right-2 text-xs" :class="{
                'text-gray-400': !isNearLimit,
                'text-yellow-500': isNearLimit && remainingChars > 0,
                'text-red-500': remainingChars <= 0
            }">
                {{ remainingChars }}
            </span>
        </div>

    </div>
</template>