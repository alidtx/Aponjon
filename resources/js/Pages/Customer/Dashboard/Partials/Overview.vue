<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios'
import { TailwindPagination } from 'laravel-vue-pagination'

const props = defineProps({

    monthly: {
        type: Number,
        default: 0
    },
    inProgress: {
        type: Number,
        default: 0
    },
    inBiding: {
        type: Number,
        default: 0
    },
})
const loading = ref(false)
const activities = ref({
    pending: [],
    accepted: []
})
const error = ref(null)

const bidActivity = async () => {
    loading.value = true
    try {
        const response = await axios.get(route('customer.bid.activity'))
        activities.value = {
            pending: (response.data.pending.data || []).filter(Boolean),
            accepted: (response.data.accepted.data || []).filter(Boolean)
        }

    } catch (err) {
        error.value = 'Failed to fetch bid activity.'
    } finally {
        loading.value = false
    }
}

const getFilteredResults = (page = 1) => {
    router.visit(route('customer.bid.activity'), {
        data: {
            page: page,
            per_page: parseInt(perPage.value),
        },
        preserveScroll: true,
        onFinish: () => {
            isLoading.value = false
        }
    })
}

const formatTime = (date) => {
    return new Date(date).toLocaleString('bn-BD', {
        hour: 'numeric',
        minute: 'numeric',
        hour12: true
    })
}

onMounted(() => {
    bidActivity()
})
</script>



<template>
    <!-- Overview Section -->
    <div id="overview" class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-2xl font-bold text-dark mb-6">ওভারভিউ</h2>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-blue-50 rounded-lg p-4 text-center">
                <i class="fas fa-gavel text-2xl text-primary mb-2"></i>
                <div class="text-lg font-bold text-dark">৳ {{ props.inBiding }}</div>
                <div class="text-sm text-gray-600">সক্রিয় কাজ</div>
            </div>
            <div class="bg-green-50 rounded-lg p-4 text-center">
                <i class="fas fa-check-circle text-2xl text-green-600 mb-2"></i>
                <div class="text-lg font-bold text-dark">৳ {{ props.inProgress }}</div>
                <div class="text-sm text-gray-600">চলমান কাজ</div>
            </div>
            <div class="bg-purple-50 rounded-lg p-4 text-center">
                <i class="fas fa-money-bill-wave text-2xl text-purple-600 mb-2"></i>
                <div class="text-lg font-bold text-dark">৳ {{ Math.round(monthly) }}</div>
                <div class="text-sm text-gray-600">এই মাসের ব্যয়</div>
            </div>
            <div class="bg-orange-50 rounded-lg p-4 text-center">
                <i class="fas fa-star text-2xl text-orange-600 mb-2"></i>
                <div class="text-lg font-bold text-dark">৪.৫</div>
                <div class="text-sm text-gray-600">গড় রেটিং</div>
            </div>

        </div>
        <div>
            <h3 class="text-lg font-bold text-dark mb-4">সাম্প্রতিক এক্টিভিটি</h3>
            <div class="space-y-3">

                <div v-for="(activity, index) in activities.accepted || []" :key="activity.id || index"
                    class="flex items-center p-3 border border-gray-200 rounded-lg">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-check text-green-600 text-sm"></i>
                    </div>

                    <div class="flex-1">
                        <p class="text-dark text-sm">
                            {{ activity?.title || 'কাজের' }} - কাজটি গ্রহণ করেছেন
                        </p>

                        <p class="text-xs text-gray-600">
                            {{ formatTime(activity?.bids?.[0]?.updated_at) }}
                        </p>
                    </div>

                    <span class="text-green-600 font-medium text-sm">
                        ৳{{ Math.round(activity?.bids?.[0]?.amount || 0) }}
                    </span>
                </div>

                <div v-for="(activity, index) in activities.pending" :key="activity.id || index"
                    class="flex items-center p-3 border border-gray-200 rounded-lg">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-gavel text-blue-600 text-sm"></i>
                    </div>

                    <div class="flex-1">
                        <p class="text-dark text-sm">
                            {{ activity?.title || 'কাজের' }} - কাজের জন্য আবেদন করেছেন
                        </p>

                        <p class="text-xs text-gray-600">
                            {{ formatTime(activity?.bids?.[0]?.created_at) }}
                        </p>
                    </div>

                    <span class="text-green-600 font-medium text-sm">
                        ৳{{ Math.round(activity?.bids?.[0]?.amount || 0) }}
                    </span>
                </div>
            </div>
        </div>
        <div class="flex justify-center items-center space-x-2 mt-8">
            <TailwindPagination :data="activities" @pagination-change-page="getFilteredResults" :limit="1"
                class="mx-5" />
        </div>
    </div>

</template>