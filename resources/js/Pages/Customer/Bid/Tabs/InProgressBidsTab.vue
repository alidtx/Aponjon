<script setup>
const props = defineProps({
    bidInProgress: {
        type: Array,
        required: true
    },
    loading: {
        type: Boolean,
        default: false
    },
    isLoading: {
        type: Boolean,
        default: false
    }
})
</script>

<template>
    <div>
        <div v-if="loading && !isLoading" class="text-center py-12">
            <p class="text-gray-500">লোড হচ্ছে...</p>
        </div>
        <div v-else-if="!bidInProgress || bidInProgress.length === 0" class="text-center py-12">
            <p class="text-gray-500">কোন একসেপ্টেড বিড নেই</p>
        </div>
        <div v-else class="space-y-4">
            <div v-for="bid in bidInProgress" :key="bid.id" class="border border-green-200 rounded-lg p-4 bg-green-50">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">{{ bid.task.title }}</h3>
                        <p class="text-gray-600 text-sm">
                            {{ bid.task.customer.name }} •
                            {{ bid.full_address || 'এলাকা' }}
                        </p>
                    </div>
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                        একসেপ্টেড
                    </span>
                </div>

                <div class="flex justify-between items-center mb-3">
                    <div class="text-sm">
                        <span class="font-medium text-gray-800">চুক্তির মূল্য: ৳{{ bid.amount }}</span>
                        <span class="text-gray-600 mx-2">•</span>
                        <span class="text-gray-600">আপনার আয়: ৳{{ Math.floor(bid.amount * 0.9) }}</span>
                    </div>
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-clock mr-1"></i>
                        অনুমোদিত: {{ new Date(bid.updated_at).toLocaleDateString('bn-BD') }}
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-600">
                        <span>গ্রাহকের যোগাযোগ: {{ bid.task.customer.phone || 'উপলব্ধ নয়' }}</span>
                    </div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50 text-sm">
                            মেসেজ দিন
                        </button>
                        <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-300 text-sm">
                            বাতিল করুন
                        </button>
                        <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-300 text-sm">
                            বিতর্কিত
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>