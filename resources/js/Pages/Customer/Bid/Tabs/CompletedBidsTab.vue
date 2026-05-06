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
</script>

<template>
    <div>
        <div v-if="loading && !isLoading" class="text-center py-12">
            <p class="text-gray-500">লোড হচ্ছে...</p>
        </div>
        <div v-else-if="!taskCompleted || taskCompleted.length === 0" class="text-center py-12">
            <p class="text-gray-500">কোন কমপ্লিটেড কাজ নেই</p>
        </div>
        <div v-else class="space-y-4">
            <div v-for="task in taskCompleted" :key="task.id" class="border border-green-200 rounded-lg p-4 bg-green-50">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">{{ task.task.title }}</h3>
                        <p class="text-gray-600 text-sm">
                            {{ task.tasker.name }} •
                            {{ task.tasker.tasker_profile.full_address || 'এলাকা' }}
                        </p>
                    </div>
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                        সম্পন্ন
                    </span>
                </div>

                <div class="flex justify-between items-center mb-3">
                    <div class="text-sm">
                        <span class="font-medium text-gray-800">প্রস্তাবিত মূল্য: ৳{{ task.amount }}</span>
                    </div>
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-clock mr-1"></i>
                        সম্পন্ন: {{ new Date(task.updated_at).toLocaleDateString('bn-BD') }}
                    </div>
                </div>

                <div class="flex justify-end">
                    <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                        রিভিউ দিন
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>