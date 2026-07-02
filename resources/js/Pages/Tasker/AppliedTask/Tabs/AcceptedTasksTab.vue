<script setup>
const props = defineProps({
    acceptedTasks: {
        type: Array,
        required: true,
    },
    loading: {
        type: Boolean,
        default: false,
    },
    isLoaded: {
        type: Boolean,
        default: false,
    },
});

defineEmits(['refresh']);

const formatCurrency = (amount) => `৳ ${Math.round(Number(amount || 0))}`;
const formatDate = (value) => value ? new Date(value).toLocaleDateString('bn-BD') : 'তারিখ নেই';
</script>

<template>
    <div>
        <div v-if="loading && !isLoaded" class="text-center py-12">
            <p class="text-gray-500">লোড হচ্ছে...</p>
        </div>
        <div v-else-if="!acceptedTasks || acceptedTasks.length === 0" class="text-center py-12">
            <p class="text-gray-500">কোন গৃহীত কাজ নেই</p>
        </div>
        <div v-else class="space-y-4">
            <div v-for="bid in acceptedTasks" :key="bid.id" class="border border-green-200 rounded-lg p-4 bg-green-50">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">{{ bid.task?.title }}</h3>
                        <p class="text-gray-600 text-sm py-1">
                            {{ bid.task?.customer?.name || 'গ্রাহক' }}
                            <span class="mx-2">•</span>
                            {{ bid.full_address || 'এলাকা' }}
                        </p>
                    </div>
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">গৃহীত</span>
                </div>

                <div class="flex justify-between items-center mb-3">
                    <div class="text-sm text-gray-700">
                        <span class="font-medium">আপনার প্রপোজাল:</span> {{ formatCurrency(bid.amount) }}
                        <span class="mx-2 text-gray-400">•</span>
                        <span class="font-medium">বাজেট:</span> {{ formatCurrency(bid.task?.budget) }}
                    </div>
                    <div class="text-sm text-gray-600">
                        গৃহীত: {{ formatDate(bid.updated_at || bid.created_at) }}
                    </div>
                </div>

                <p v-if="bid.proposal" class="text-sm text-gray-700 mb-2">
                    <span class="font-medium">প্রস্তাবনা:</span> {{ bid.proposal }}
                </p>
            </div>
        </div>
    </div>
</template>
