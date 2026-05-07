<script setup>
import { ref, onMounted } from 'vue'

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
    },
    errors: {
        type: Object,
        default: () => ({})
    }
})

const emit = defineEmits(['confirm', 'cancel'])
const disputeReason = ref('')

onMounted(() => {
    disputeReason.value = ''
})

const handleConfirm = () => {
    const reason = disputeReason.value.trim()
    if (reason.length >= 5) { 
        emit('confirm', reason)
    }
}

const handleCancel = () => {
    disputeReason.value = ''
    emit('cancel')
}
</script>

<template>
    <div class="p-6">
        <div class="text-center">
            <i class="fas fa-exclamation-triangle text-red-500 text-5xl mb-4"></i>
            <h3 class="text-lg font-bold text-gray-800 mb-2">বিডটি কেন বিতর্কিত?</h3>
            <p class="text-gray-600 mb-4">অনুগ্রহ করে এই বিডটি বিতর্কিত করার কারণ উল্লেখ করুন।</p>
            
            <div class="bg-gray-50 rounded-lg p-3 mb-4 text-left">
                <p class="text-sm"><strong>টাস্ক:</strong> {{ title }}</p>
                <p class="text-sm"><strong>টাস্কার:</strong> {{ name }}</p>
                <p class="text-sm"><strong>চুক্তির মূল্য:</strong> ৳{{ Math.round(amount) }}</p>
            </div>
            <div class="mb-6 text-left">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    বিতর্কিত করার কারণ উল্লেখ করুন <span class="text-red-500">*</span>
                </label>
                <textarea
                    v-model="disputeReason"
                    rows="4"
                    placeholder="বিতর্কিত করার কারণ উল্লেখ করুন (কমপক্ষে ৫ অক্ষর)..."
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent resize-none"
                    :disabled="isProcessing"
                ></textarea>
                <p v-if="errors.dispute_reason" class="text-red-500 text-sm mt-1">
                    {{ errors.dispute_reason[0] }}
                </p>
                <p class="text-xs text-gray-500 mt-1">
                    আপনার মতামত আমাদের উন্নত করতে সাহায্য করবে
                </p>
            </div>
            
            <div class="flex justify-center gap-3">
                <button 
                    @click="handleCancel"
                    :disabled="isProcessing"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 disabled:opacity-50 transition-colors"
                >
                    না
                </button>
                <button 
                    @click="handleConfirm"
                    :disabled="isProcessing || disputeReason.trim().length < 5"
                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                >
                    <i v-if="isProcessing" class="fas fa-spinner fa-spin mr-2"></i>
                    <i v-else class="fas fa-check mr-2"></i>
                    {{ isProcessing ? 'প্রক্রিয়াধীন...' : 'হ্যাঁ, বিতর্কিত করুন' }}
                </button>
            </div>
        </div>
    </div>
</template>