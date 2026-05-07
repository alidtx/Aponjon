<script setup>
import { computed } from 'vue'

const props = defineProps({
    task: {
        type: Object,
        default: () => null
    }
})

const urgency = computed(() => {
    const map = {
        normal: { label: 'সাধারণ', icon: 'fa-circle', color: 'green', bg: 'bg-green-100', text: 'text-green-800', border: 'border-green-200' },
        urgent: { label: 'জরুরি', icon: 'fa-exclamation-circle', color: 'yellow', bg: 'bg-yellow-100', text: 'text-yellow-800', border: 'border-yellow-200' },
        emergency: { label: 'ইমার্জেন্সি', icon: 'fa-bolt', color: 'red', bg: 'bg-red-100', text: 'text-red-800', border: 'border-red-200' }
    }
    const level = props.task?.task?.emergency?.toLowerCase() || 'normal'
    return map[level] || map.normal
})

const status = computed(() => {
    const map = {
        pending: { label: 'পেন্ডিং', icon: 'fa-clock', bg: 'bg-yellow-100', text: 'text-yellow-800' },
        in_progress: { label: 'প্রগতিতে', icon: 'fa-spinner fa-pulse', bg: 'bg-blue-100', text: 'text-blue-800' },
        completed: { label: 'সম্পন্ন', icon: 'fa-check-circle', bg: 'bg-green-100', text: 'text-green-800' },
        cancelled: { label: 'বাতিল', icon: 'fa-times-circle', bg: 'bg-red-100', text: 'text-red-800' },
        accepted: { label: 'গৃহীত', icon: 'fa-check-circle', bg: 'bg-green-100', text: 'text-green-800' },
        disputed: { label: 'বিতর্কিত', icon: 'fa-exclamation-triangle', bg: 'bg-red-100', text: 'text-red-800' }
    }
    const current = props.task?.status?.toLowerCase() || 'pending'
    return map[current] || map.pending
})

const formatBudget = (amount) => {
    if (!amount) return '৳ ০'
    return new Intl.NumberFormat('bn-BD', {
        style: 'currency',
        currency: 'BDT',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(amount)
}

const formatDate = (date) => {
    if (!date) return 'N/A'
    return new Date(date).toLocaleDateString('bn-BD', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
}
const getTimeAgo = (date) => {
    if (!date) return 'N/A'
    const seconds = Math.floor((new Date() - new Date(date)) / 1000)
    if (seconds < 0) return 'এখনই'
    
    const intervals = {
        year: 31536000,
        month: 2592000,
        day: 86400,
        hour: 3600,
        minute: 60
    }
    
    for (const [unit, secondsInUnit] of Object.entries(intervals)) {
        const interval = Math.floor(seconds / secondsInUnit)
        if (interval >= 1) {
            const banglaUnits = {
                year: 'বছর',
                month: 'মাস',
                day: 'দিন',
                hour: 'ঘন্টা',
                minute: 'মিনিট'
            }
            return `${interval} ${banglaUnits[unit]} আগে`
        }
    }
    return 'এখনই'
}
</script>

<template>
    <div v-if="task" class="space-y-6">
        <div class="border-b pb-4">
            <div class="flex flex-wrap gap-2 mb-3">
                <span :class="['inline-flex items-center px-3 py-1 rounded-full text-sm font-medium', urgency.bg, urgency.text]">
                    <i :class="['fas', urgency.icon, 'mr-2']"></i>
                    {{ urgency.label }}
                </span>
                <span :class="['inline-flex items-center px-3 py-1 rounded-full text-sm font-medium', status.bg, status.text]">
                    <i :class="['fas', status.icon, 'mr-2']"></i>
                    {{ status.label }}
                </span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ task.task?.title || task.proposal || 'N/A' }}</h3>
            <p class="text-sm text-gray-500">
                <i class="fas fa-hashtag mr-1"></i>
                টাস্ক নম্বর: {{ task.task?.task_number || 'N/A' }}
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 text-center">
                <i class="fas fa-chart-line text-blue-600 text-xl mb-2"></i>
                <p class="text-2xl font-bold text-gray-900">{{ formatBudget(task.amount || task.task?.budget) }}</p>
                <p class="text-xs text-gray-600">বাজেট</p>
            </div>
            
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 text-center">
                <i class="fas fa-folder-open text-purple-600 text-xl mb-2"></i>
                <p class="text-sm font-semibold text-gray-900">{{ task.task?.category?.name  || 'N/A' }}</p>
                <p class="text-xs text-gray-600">ক্যাটাগরি</p>
            </div>
                    
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-4 text-center">
                <i class="fas fa-clock text-orange-600 text-xl mb-2"></i>
                <p class="text-sm font-medium text-gray-900">{{ getTimeAgo(task.created_at) }}</p>
                <p class="text-xs text-gray-600">পোস্ট করা হয়েছে</p>
            </div>
        </div>
        <div v-if="task.tasker" class="bg-gray-50 rounded-xl p-4 border border-gray-200">
            <h4 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                <i class="fas fa-user-check text-primary mr-2"></i>
                টাস্কারের তথ্য
            </h4>
            <div class="flex items-center space-x-4">
                <img v-if="task.tasker.avatar" :src="task.tasker.avatar" class="w-16 h-16 rounded-full object-cover" />
                <div class="flex-1">
                    <p class="font-semibold text-gray-900">{{ task.tasker.name }}</p>
                    <p class="text-sm text-gray-600">রেটিং: {{ task.tasker.tasker_profile?.rating || 0 }}/5</p>
                    <p class="text-sm text-gray-600">{{ task.tasker.tasker_profile?.full_address || 'ঠিকানা নেই' }}</p>
                </div>
            </div>
        </div>

        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                <i class="fas fa-file-alt text-primary mr-2"></i>
                বিতর্কের কারন
            </h4>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">
                    {{ task.task.customer_notes }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-md font-semibold text-gray-900 mb-3 flex items-center">
                    <i class="fas fa-info-circle text-primary mr-2"></i>
                    মৌলিক তথ্য
                </h4>
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">বিতর্কিত আইডি</span>
                        <span class="text-sm font-mono font-medium text-gray-900">#{{ task.id }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">এস্টিমেটেড ঘন্টা</span>
                        <span class="text-sm font-medium text-gray-900">{{ task.estimated_hours || 'N/A' }} ঘন্টা</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">অ্যাভেইলেবিলিটি</span>
                        <span class="text-sm font-medium text-gray-900">{{ task.availability || 'N/A' }}</span>
                    </div>
                    
                    <div v-if="task.specific_date" class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">নির্দিষ্ট তারিখ</span>
                        <span class="text-sm font-medium text-gray-900">{{ formatDate(task.specific_date) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div v-else class="text-center py-8">
        <i class="fas fa-spinner fa-pulse text-4xl text-gray-400 mb-3"></i>
        <p class="text-gray-500">লোড হচ্ছে...</p>
    </div>
</template>

<style scoped>
.space-y-6 > * {
    animation: fadeInUp 0.4s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>