<script setup>
import { ref, computed } from 'vue'
import PdfIcon from './Icons/PdfIcon.vue'

const props = defineProps({
    modelValue: {
        type: File,
        default: null
    },
    acceptedType: {
        type: String,
        default: 'image/*'
    },
    placeholder: {
        type: String,
        default: 'ফাইল নির্বাচন করুন বা ড্র্যাগ করুন'
    },
})

const emit = defineEmits(['update:modelValue'])

const fileName = ref('')
const imagePreviewUrl = ref(null)
const fileType = ref(null)

const isPdfPreview = computed(() => {
    return fileType.value === 'application/pdf'
})

function handleFileChange(event) {
    const file = event.target.files[0]

    if (file) {
        fileName.value = file.name
        fileType.value = file.type
        imagePreviewUrl.value = URL.createObjectURL(file)

        emit('update:modelValue', file)   // 👈 send file to parent
    } else {
        fileName.value = ''
        imagePreviewUrl.value = null
        fileType.value = null

        emit('update:modelValue', null)
    }
}
</script>

<template>
    <div
        class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-primary transition-colors duration-200 relative">

        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>

        <input type="file" :accept="acceptedType" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
            @change="handleFileChange" />

        <div v-if="imagePreviewUrl && isPdfPreview" class="flex justify-center mb-2">
            <PdfIcon width="50" height="46" />
        </div>

        <img v-else-if="imagePreviewUrl" :src="imagePreviewUrl" class="mx-auto mb-2 h-12 object-contain rounded" />

        <p v-else class="text-gray-600 mb-1">
            {{ placeholder }}
        </p>

        <p class="text-sm text-gray-500">JPG, PNG, PDF (সর্বোচ্চ ৫MB)</p>

    </div>
</template>