<script setup>
const props = defineProps({
    title: {
        type: String,
        default: ''
    },
    name: {
        type: String,
        default: ''
    },
    amount: {
        type: [String, Number],
        default: 0
    },
    isProcessing: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['confirm', 'cancel'])

const handleConfirm = () => {
    emit('confirm')
}

const handleCancel = () => {
    emit('cancel')
}
</script>

<template>
    <div class="p-6">
        <div class="text-center">
            <i class="fas fa-question-circle text-yellow-500 text-5xl mb-4"></i>
            <h3 class="text-lg font-bold text-gray-800 mb-2">বিড গ্রহণ করুন?</h3>
            <p class="text-gray-600 mb-4">আপনি কি এই আবেদনটি গ্রহণ করতে চান?</p>
            
            <div class="bg-gray-50 rounded-lg p-3 mb-6 text-left">
                <p class="text-sm"><strong>টাস্ক:</strong> {{ title }}</p>
                <p class="text-sm"><strong>টাস্কার:</strong> {{ name }}</p>
                <p class="text-sm"><strong>প্রস্তাবিত মূল্য:</strong> ৳{{ Math.round(amount) }}</p>
            </div>
            
            <div class="flex justify-center gap-3">
                <button 
                    @click="handleCancel"
                    :disabled="isProcessing"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 disabled:opacity-50"
                >
                    বাতিল
                </button>
                <button 
                    @click="handleConfirm"
                    :disabled="isProcessing"
                    class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 disabled:opacity-50"
                >
                    <i v-if="isProcessing" class="fas fa-spinner fa-spin mr-2"></i>
                    <i v-else class="fas fa-check mr-2"></i>
                    {{ isProcessing ? 'প্রক্রিয়াধীন...' : 'গ্রহণ করুন' }}
                </button>
            </div>
        </div>
    </div>
</template>