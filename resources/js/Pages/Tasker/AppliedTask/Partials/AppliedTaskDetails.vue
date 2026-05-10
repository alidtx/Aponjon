<script setup>
import { computed } from 'vue'

const props = defineProps({
    appliedTask: {
        type: Object,
        default: () => null
    }
})

const status = computed(() => {
    const map = {
        pending: { label: 'পেন্ডিং', icon: 'fa-clock', bg: 'bg-yellow-100', text: 'text-yellow-800' },
        accepted: { label: 'গৃহীত', icon: 'fa-check-circle', bg: 'bg-green-100', text: 'text-green-800' },
        rejected: { label: 'প্রত্যাখ্যাত', icon: 'fa-times-circle', bg: 'bg-red-100', text: 'text-red-800' },
        in_progress: { label: 'প্রগতিতে', icon: 'fa-spinner fa-pulse', bg: 'bg-blue-100', text: 'text-blue-800' },
        completed: { label: 'সম্পন্ন', icon: 'fa-check-circle', bg: 'bg-green-100', text: 'text-green-800' },
        cancelled: { label: 'বাতিল', icon: 'fa-times-circle', bg: 'bg-red-100', text: 'text-red-800' }
    }
    const current = props.appliedTask?.status?.toLowerCase() || 'pending'
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

const getTaskStatusLabel = (status) => {
    const statusMap = {
        posted: 'পোস্ট করা',
        in_progress: 'প্রগতিতে',
        completed: 'সম্পন্ন',
        cancelled: 'বাতিল',
        pending: 'পেন্ডিং'
    }
    return statusMap[status?.toLowerCase()] || status || 'N/A'
}

const getTaskStatusClass = (status) => {
    const classMap = {
        posted: 'bg-blue-100 text-blue-800',
        in_progress: 'bg-yellow-100 text-yellow-800',
        completed: 'bg-green-100 text-green-800',
        cancelled: 'bg-red-100 text-red-800',
        pending: 'bg-orange-100 text-orange-800'
    }
    return classMap[status?.toLowerCase()] || 'bg-gray-100 text-gray-800'
}
</script>



<template>
    <div v-if="appliedTask" class="space-y-6">
        <div class="border-b pb-4">
            <div class="flex flex-wrap gap-2 mb-3">
                <span :class="['inline-flex items-center px-3 py-1 rounded-full text-sm font-medium', status.bg, status.text]">
                    <i :class="['fas', status.icon, 'mr-2']"></i>
                    {{ status.label }}
                </span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ appliedTask.task?.title || 'N/A' }}</h3>
            <p class="text-sm text-gray-500">
                <i class="fas fa-hashtag mr-1"></i>
                কাজের নম্বর: {{ appliedTask.task?.task_number || 'N/A' }}
            </p>
            <p class="text-xs text-gray-400 mt-1">
                <i class="fas fa-calendar-alt mr-1"></i>
                আবেদনের তারিখ: {{ formatDate(appliedTask.created_at) }}
            </p>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 text-center">
                <i class="fas fa-money-bill-wave text-green-600 text-xl mb-2"></i>
                <p class="text-2xl font-bold text-gray-900">{{ formatBudget(appliedTask.task?.budget) }}</p>
                <p class="text-xs text-gray-600">বাজেট</p>
            </div>
            
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 text-center">
                <i class="fas fa-hourglass-half text-blue-600 text-xl mb-2"></i>
                <p class="text-sm font-medium text-gray-900">{{ appliedTask.estimated_hours || 'নির্ধারিত নয়' }}</p>
                <p class="text-xs text-gray-600">আনুমানিক সময়</p>
            </div>
        </div>
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                <i class="fas fa-info-circle text-primary mr-2"></i>
                কাজের বিবরণ
            </h4>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">
                    {{ appliedTask.task?.customer_notes || 'কোন বিবরণ প্রদান করা হয়নি' }}
                </p>
            </div>
        </div>
        <div v-if="appliedTask.tasker" class="bg-gray-50 rounded-xl p-4 border border-gray-200">
            <h4 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                <i class="fas fa-user-check text-primary mr-2"></i>
                টাস্কারের তথ্য
            </h4>
            <div class="flex items-center space-x-4">
                <img 
                    v-if="appliedTask.tasker.avatar" 
                    :src="appliedTask.tasker.avatar" 
                    class="w-16 h-16 rounded-full object-cover border-2 border-primary"
                    :alt="appliedTask.tasker.name"
                />
                <div v-else class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center">
                    <i class="fas fa-user text-gray-500 text-2xl"></i>
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-gray-900">{{ appliedTask.tasker.name }}</p>
                    <div class="flex items-center mt-1">
                        <div class="flex text-yellow-400">
                            <i v-for="n in 5" :key="n" class="fas fa-star text-xs" :class="{ 'text-gray-300': n > (appliedTask.tasker.tasker_profile?.rating || 0) }"></i>
                        </div>
                        <span class="text-sm text-gray-600 ml-2">({{ appliedTask.tasker.tasker_profile?.rating || 0 }})</span>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        {{ appliedTask.tasker.tasker_profile?.full_address || 'ঠিকানা নেই' }}
                    </p>
                    <div class="flex items-center mt-1">
                        <span :class="['inline-flex items-center px-2 py-0.5 rounded text-xs', appliedTask.tasker.is_verified ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600']">
                            <i :class="['fas', appliedTask.tasker.is_verified ? 'fa-check-circle' : 'fa-clock', 'mr-1']"></i>
                            {{ appliedTask.tasker.is_verified ? 'ভেরিফাইড' : 'অন ভেরিফাইড' }}
                        </span>
                        <span :class="['inline-flex items-center px-2 py-0.5 rounded text-xs ml-2', appliedTask.tasker.tasker_profile?.is_online ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600']">
                            <i :class="['fas', appliedTask.tasker.tasker_profile?.is_online ? 'fa-circle' : 'fa-circle', 'mr-1', appliedTask.tasker.tasker_profile?.is_online ? 'text-green-500' : 'text-gray-400']"></i>
                            {{ appliedTask.tasker.tasker_profile?.is_online ? 'অনলাইন' : 'অফলাইন' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <h4 class="text-md font-semibold text-gray-900 mb-3 flex items-center">
                <i class="fas fa-list-ul text-primary mr-2"></i>
                অতিরিক্ত তথ্য
            </h4>
            <div class="space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-600">টাস্ক আইডি</span>
                    <span class="text-sm font-mono font-medium text-gray-900">#{{ appliedTask.id }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-600">কাজের অবস্থা</span>
                    <span :class="['inline-flex items-center px-2 py-1 rounded-full text-xs font-medium', getTaskStatusClass(appliedTask.task?.status)]">
                        {{ getTaskStatusLabel(appliedTask.task?.status) }}
                    </span>
                </div>
                
                <div v-if="appliedTask.availability" class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-600">উপলব্ধতা</span>
                    <span class="text-sm font-medium text-gray-900">{{ appliedTask.availability }}</span>
                </div>
                
                <div v-if="appliedTask.specific_date" class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-600">নির্দিষ্ট তারিখ</span>
                    <span class="text-sm font-medium text-gray-900">{{ formatDate(appliedTask.specific_date) }}</span>
                </div>
                
                <div v-if="appliedTask.proposal" class="py-2">
                    <span class="text-sm text-gray-600 block mb-1">প্রস্তাবনা</span>
                    <p class="text-sm font-medium text-gray-900 bg-gray-50 p-2 rounded">{{ appliedTask.proposal }}</p>
                </div>
                
                <div v-if="appliedTask.full_address" class="py-2">
                    <span class="text-sm text-gray-600 block mb-1">পূর্ণ ঠিকানা</span>
                    <p class="text-sm font-medium text-gray-900">{{ appliedTask.full_address }}</p>
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

.bg-gradient-to-br {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.bg-gradient-to-br:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
</style>