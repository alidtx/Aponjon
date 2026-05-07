<script setup>
import { computed, ref } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    payableBids: {
        type: Object,
        default: () => null
    }
})

const task = computed(() => props.payableBids)
const isProcessing = ref(false)
const showPaymentModal = ref(false)
const paymentAmount = ref(0)

const formatBudget = (amount) => {
    if (!amount && amount !== 0) return '৳ ০'
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
        day: 'numeric'
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

const paymentStatus = computed(() => {
    if (task.value?.payment_status === 'paid') {
        return { label: 'পরিশোধিত', icon: 'fa-check-circle', bg: 'bg-green-100', text: 'text-green-800' }
    } else if (task.value?.payment_status === 'pending') {
        return { label: 'বাকি', icon: 'fa-clock', bg: 'bg-yellow-100', text: 'text-yellow-800' }
    } else if (task.value?.payment_status === 'processing') {
        return { label: 'প্রক্রিয়াধীন', icon: 'fa-spinner fa-pulse', bg: 'bg-blue-100', text: 'text-blue-800' }
    }
    return { label: 'অনিষ্পন্ন', icon: 'fa-hourglass', bg: 'bg-gray-100', text: 'text-gray-800' }
})

const payableAmount = computed(() => {
    return task.value?.settled_amount || task.value?.amount || task.value?.task?.budget || 0
})

const processPayment = () => {
    paymentAmount.value = payableAmount.value
    showPaymentModal.value = true
}

const confirmPayment = () => {
    isProcessing.value = true
    
    router.post(`/payments/process/${task.value.id}`, {
        amount: paymentAmount.value,
        dispute_id: task.value.id
    }, {
        onSuccess: () => {
            isProcessing.value = false
            showPaymentModal.value = false
            
        },
        onError: () => {
            isProcessing.value = false
            
        }
    })
}

const closeModal = () => {
    showPaymentModal.value = false
    paymentAmount.value = 0
}
</script>

<template>
    <div v-if="task" class="space-y-6">
        
        <div class="border-b pb-4">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ task.task?.title || 'N/A' }}</h3>
                    <p class="text-sm text-gray-500">
                        <i class="fas fa-hashtag mr-1"></i>
                        টাস্ক নম্বর: {{ task.task?.task_number || 'N/A' }}
                    </p>
                </div>
                <span :class="['inline-flex items-center px-3 py-1 rounded-full text-sm font-medium', paymentStatus.bg, paymentStatus.text]">
                    <i :class="['fas', paymentStatus.icon, 'mr-2']"></i>
                    {{ paymentStatus.label }}
                </span>
            </div>
        </div>

        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl p-6 text-white">
            <div class="text-center">
                <p class="text-sm opacity-90 mb-2">পরিশোধযোগ্য অর্থের পরিমাণ</p>
                <p class="text-4xl font-bold mb-4">{{ formatBudget(payableAmount) }}</p>
                
                <button 
                    v-if="task.payment_status !== 'paid'"
                    @click="processPayment"
                    :disabled="isProcessing"
                    class="bg-white text-indigo-600 px-6 py-2 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-200 disabled:opacity-50"
                >
                    <i class="fas fa-credit-card mr-2"></i>
                    {{ isProcessing ? 'প্রক্রিয়াধীন...' : 'এখনই পরিশোধ করুন' }}
                </button>
                
                <div v-else class="bg-green-500 bg-opacity-30 inline-flex items-center px-4 py-2 rounded-lg">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>পেমেন্ট সম্পন্ন হয়েছে</span>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 text-center">
                <i class="fas fa-money-bill-wave text-green-600 text-xl mb-2"></i>
                <p class="text-sm text-gray-600">মূল বাজেট</p>
                <p class="text-xl font-bold text-gray-900">{{ formatBudget(task.amount || task.task?.budget) }}</p>
            </div>
            
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 text-center">
                <i class="fas fa-hand-holding-usd text-blue-600 text-xl mb-2"></i>
                <p class="text-sm text-gray-600">নিষ্পত্তিকৃত অর্থ</p>
                <p class="text-xl font-bold text-blue-700">{{ formatBudget(task.settled_amount) }}</p>
            </div>
            
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 text-center">
                <i class="fas fa-calendar-check text-purple-600 text-xl mb-2"></i>
                <p class="text-sm text-gray-600">কাজ সমাপ্তির তারিখ</p>
                <p class="text-sm font-semibold text-gray-900">{{ formatDate(task.updated_at || task.created_at) }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

            <div v-if="task.task?.description" class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                <h4 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                    <i class="fas fa-clipboard-list text-primary mr-2"></i>
                    কাজের বিবরণ
                </h4>
                <p class="text-gray-700 text-sm leading-relaxed">
                    {{ task.task.description }}
                </p>
            </div>
        </div>
        <div class="border-t pt-4">
            <h4 class="text-md font-semibold text-gray-900 mb-3 flex items-center">
                <i class="fas fa-info-circle text-primary mr-2"></i>
                লেনদেন সংক্রান্ত তথ্য
            </h4>
            <div class="space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-600">বিতর্ক আইডি</span>
                    <span class="text-sm font-mono font-medium text-gray-900">#{{ task.id }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-600">ট্রানজেকশন আইডি</span>
                    <span class="text-sm font-mono font-medium text-gray-900">{{ task.transaction_id || 'N/A' }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-600">পেমেন্ট পদ্ধতি</span>
                    <span class="text-sm font-medium text-gray-900">{{ task.payment_method || 'N/A' }}</span>
                </div>

                <div v-if="task.payment_date" class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-600">পেমেন্টের তারিখ</span>
                    <span class="text-sm font-medium text-gray-900">{{ formatDate(task.payment_date) }}</span>
                </div>

                <div v-if="task.settled_amount" class="flex justify-between items-center py-2 bg-green-50 px-3 rounded-lg">
                    <span class="text-sm font-semibold text-gray-700">নিষ্পত্তিকৃত অর্থ</span>
                    <span class="text-lg font-bold text-green-700">{{ formatBudget(task.settled_amount) }}</span>
                </div>
            </div>
        </div>

        <div v-if="showPaymentModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" @click.self="closeModal">
            <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-credit-card text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">পেমেন্ট নিশ্চিত করুন</h3>
                    <p class="text-gray-600 mt-2">আপনি নিচের অর্থ টাস্কারকে পরিশোধ করতে যাচ্ছেন</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-4 mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-600">টাস্ক নম্বর</span>
                        <span class="font-medium">{{ task.task?.task_number }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-600">টাস্কার</span>
                        <span class="font-medium">{{ task.tasker?.name }}</span>
                    </div>
                    <div class="border-t pt-2 mt-2">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-900">পরিশোধযোগ্য অর্থ</span>
                            <span class="text-2xl font-bold text-blue-600">{{ formatBudget(paymentAmount) }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button 
                        @click="closeModal"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"
                    >
                        বাতিল
                    </button>
                    <button 
                        @click="confirmPayment"
                        :disabled="isProcessing"
                        class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50"
                    >
                        <i v-if="isProcessing" class="fas fa-spinner fa-pulse mr-2"></i>
                        {{ isProcessing ? 'প্রক্রিয়াধীন...' : 'নিশ্চিত করুন' }}
                    </button>
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