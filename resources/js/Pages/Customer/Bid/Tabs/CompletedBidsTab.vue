<script setup>
const props = defineProps({
    taskCompleted: {
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

console.log(props.taskCompleted);
</script>

<template>
    <div>
        <div v-if="loading && !isLoading" class="text-center py-12">
            <p class="text-gray-500">লোড হচ্ছে...</p>
        </div>
        <div v-else-if="!taskCompleted || taskCompleted.length === 0" class="text-center py-12">
            <p class="text-gray-500">কোন রিজেক্টেড বিড নেই</p>
        </div>
        <div v-else class="space-y-4">
            <div v-for="bid in taskCompleted" :key="bid.id" class="border border-red-200 rounded-lg p-4 bg-red-50">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">{{ bid.title }}</h3>
                        <p class="text-gray-600 text-sm">
                            {{ bid.customer.name }} •
                            {{ bid.full_address || 'এলাকা' }}
                        </p>
                    </div>
                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm">
                        রিজেক্টেড
                    </span>
                </div>

                <div class="flex justify-between items-center mb-3">
                    <div class="text-sm">
                        <span class="font-medium text-gray-800">প্রস্তাবিত মূল্য: ৳{{ bid.amount }}</span>
                    </div>
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-clock mr-1"></i>
                        রিজেক্টেড: {{ new Date(bid.updated_at).toLocaleDateString('bn-BD') }}
                    </div>
                </div>

                <div class="flex justify-end">
                    <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                        রিবিউ দিন
                    </button>
                </div>
            </div>

        </div>
    </div>
</template>