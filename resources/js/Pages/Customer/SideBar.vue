<script setup>
import { Link } from '@inertiajs/vue3';
import { computed, onMounted, ref } from 'vue';
import axios from 'axios'

const loading = ref(false)
const profile = ref([])
const total_spend = ref(0)
const successRate = ref(0)
const error = ref(null)
const userName = computed(() => profile.value?.name || '')
const designation = computed(() => profile.value?.customer_profile?.designation || '')
const profile_photo = computed(() => profile.value?.customer_profile?.profile_photo)
const rating = computed(() => profile.value?.customer_profile?.rating || 0)


const fullStars = computed(() => {
    return Math.floor(rating.value)
})

const hasHalfStar = computed(() => {
    return (rating.value % 1) >= 0.5
})

const emptyStars = computed(() => {
    return 5 - fullStars.value - (hasHalfStar.value ? 1 : 0)
})

const CustomerProfile = async () => {
    loading.value = true
    try {
        const response = await axios.get(route('customer.sidebar.info'))
        profile.value = response.data.data

    } catch (err) {
        error.value = 'Failed to fetch profile list.'
    } finally {
        loading.value = false
    }
}

const CustomerTotalSpend = async () => {
    loading.value = true
    try {
        const totalSpend = await axios.get(route('customer.total.spend'))
        total_spend.value = totalSpend.data

    } catch (err) {
        error.value = 'Failed to fetch total spend.'
    } finally {
        loading.value = false
    }
}

const CustomerSuccessRate = async () => {
    loading.value = true
    try {
        const CustomerSuccessRate = await axios.get(route('customer.success.rate'))
        successRate.value = CustomerSuccessRate.data

    } catch (err) {
        error.value = 'Failed to fetch success rate.'
    } finally {
        loading.value = false
    }
}

onMounted(() => {
    CustomerProfile()
    CustomerTotalSpend()
    CustomerSuccessRate()
})  
</script>

<template>
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
            <div class="text-center mb-6">
                <img :src="profile_photo || '/img/profile/dummy-image.jpg'" alt="Profile"
                    class="w-20 h-20 rounded-full mx-auto mb-4">
                <h2 class="text-xl font-bold text-dark">{{ userName }}</h2>
                <p class="text-gray-600 text-sm">{{ designation }}</p>
                <div class="flex justify-center space-x-1 text-yellow-400 mt-2">
                    <i v-for="n in fullStars" :key="'f' + n" class="fas fa-star"></i>
                    <i v-if="hasHalfStar" class="fas fa-star-half-alt"></i>
                    <i v-for="n in emptyStars" :key="'e' + n" class="far fa-star"></i>
                </div>
                <span class="text-sm text-gray-600">{{ rating.toFixed(1) }}/5.0 (৪৫ রিভিউ)</span>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-sm text-gray-600">সাফল্যের হার</span>
                    <span class="text-sm font-bold text-green-600">{{ successRate }}%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">মোট খরচ</span>
                    <span class="text-sm font-bold text-primary">৳ {{ Math.round(total_spend) }}</span>
                </div>
            </div>
            <nav class="space-y-2">
                <Link :href="route('customer.dashboard')"
                    class="flex items-center p-3 rounded-lg font-medium transition-colors"
                    :class="route().current('customer.dashboard') ? 'text-primary bg-blue-50' : 'text-gray-600 hover:bg-gray-50'">
                    <i class="fas fa-chart-pie mr-3 text-primary"></i>ওভারভিউ
                </Link>
                <Link :href="route('customer.create.gig')"
                    class="flex items-center p-3 rounded-lg font-medium transition-colors"
                    :class="route().current('customer.create.gig') ? 'text-primary bg-blue-50' : 'text-gray-600 hover:bg-gray-50'">
                    <i class="fas fa-plus mr-3 text-primary"></i>নতুন কাজ তৈরি করুন
                </Link>
                <Link :href="route('tasker.assigned.tasks')"
                    class="flex items-center p-3 rounded-lg font-medium transition-colors"
                    :class="route().current('tasker.assigned.tasks') ? 'text-primary bg-blue-50' : 'text-gray-600 hover:bg-gray-50'">
                    <i class="fas fa-tasks mr-3 text-primary"></i>আপনাকে দেওয়া কাজ
                </Link>
                <Link :href="route('tasker.pending.tasks')"
                    class="flex items-center p-3 rounded-lg font-medium transition-colors"
                    :class="route().current('tasker.pending.tasks') ? 'text-primary bg-blue-50' : 'text-gray-600 hover:bg-gray-50'">
                    <i class="fas fa-gavel mr-3 text-primary"></i>আপনার অপেক্ষমাণ কাজ
                </Link>
            </nav>
        </div>
    </div>
</template>