<script setup>
const props = defineProps({
    appliedTasks: {
        type: Array,
        required: true,
    },
    loading: {
        type: Boolean,
        default: false,
    },
});

const formatCurrency = (amount) => `৳ ${Math.round(Number(amount || 0))}`;
const formatDate = (value) => value ? new Date(value).toLocaleDateString('bn-BD') : 'তারিখ নেই';

const resolveStatus = (bid) => {
    if (bid.task?.status === 'completed') {
        return { label: 'কমপ্লিটেড', className: 'bg-red-100 text-red-800' };
    }

    if (bid.task?.status === 'in_progress') {
        return { label: 'চলমান', className: 'bg-blue-100 text-blue-800' };
    }

    if (bid.status === 'accepted' || bid.task?.status === 'assigned') {
        return { label: 'গৃহীত', className: 'bg-green-100 text-green-800' };
    }

    return { label: 'আবেদন করা হয়েছে', className: 'bg-yellow-100 text-yellow-800' };
};
</script>

<template>
    <div>
        <div v-if="loading" class="text-center py-12">
            <p class="text-gray-500">লোড হচ্ছে...</p>
        </div>
        <div v-else-if="!appliedTasks || appliedTasks.length === 0" class="text-center py-12">
            <p class="text-gray-500">কোন প্রাপ্ত বিড নেই</p>
        </div>
        <div v-else class="space-y-4">
            <div v-for="bid in appliedTasks" :key="bid.id" class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">{{ bid.task?.title }}</h3>
                        <p class="text-gray-600 text-sm py-1">
                            {{ bid.task?.customer?.name || 'গ্রাহক' }}
                            <span class="mx-2">•</span>
                            {{ bid.full_address || 'এলাকা' }}
                        </p>
                        <p class="text-gray-500 text-sm">কাজের নম্বর: {{ bid.task?.task_number || 'N/A' }}</p>
                    </div>

                    <span class="px-3 py-1 rounded-full text-sm" :class="resolveStatus(bid).className">
                        {{ resolveStatus(bid).label }}
                    </span>
                </div>

                <div class="flex justify-between items-center mb-3">
                    <div class="text-sm text-gray-700">
                        <span class="font-medium">আপনার প্রপোজাল:</span> {{ formatCurrency(bid.amount) }}
                        <span class="mx-2 text-gray-400">•</span>
                        <span class="font-medium">বাজেট:</span> {{ formatCurrency(bid.task?.budget) }}
                    </div>
                    <div class="text-sm text-gray-600">
                        আবেদন করা: {{ formatDate(bid.updated_at || bid.created_at) }}
                    </div>
                </div>

                <p v-if="bid.proposal" class="text-sm text-gray-700 mb-2">
                    <span class="font-medium">প্রস্তাবনা:</span> {{ bid.proposal }}
                </p>

                <p v-if="bid.task?.customer_notes" class="text-sm text-gray-700">
                    <span class="font-medium">গ্রাহকের নোট:</span> {{ bid.task.customer_notes }}
                </p>
            </div>
        </div>
    </div>
</template>
