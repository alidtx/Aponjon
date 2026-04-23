<script setup>
import { computed } from 'vue';

const props = defineProps({
    activeBids: {
        type: Object,
        default: () => ({})
    },
    monthly: {
        type: Number,
        default: 0
    },
    recentActivity: {
        type: Object,
        default: () => ({})
    },
})

const inProgressBids = computed(() => { return props.activeBids?.filter(bid => bid.status === 'accepted') || [] })
const acitveBids = computed(() => { return props.activeBids?.filter(bid => bid.status === 'pending') || [] })
const appliedTask = computed(() => {
    return props.recentActivity?.data?.filter(bid => bid.status === 'pending') || []
})
const approvedTask = computed(() => { return props.recentActivity?.data?.filter(bid => bid.status === 'accepted') || [] })
const formatTime = (date) => {
    return new Date(date).toLocaleString('bn-BD', {
        hour: 'numeric',
        minute: 'numeric',
        hour12: true
    })
}


</script>



<template>
    <!-- Overview Section -->
    <div id="overview" class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-2xl font-bold text-dark mb-6">ওভারভিউ</h2>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-blue-50 rounded-lg p-4 text-center">
                <i class="fas fa-gavel text-2xl text-primary mb-2"></i>
                <div class="text-lg font-bold text-dark">৳ {{ acitveBids.length }}</div>
                <div class="text-sm text-gray-600">সক্রিয় বিড</div>
            </div>
            <div class="bg-green-50 rounded-lg p-4 text-center">
                <i class="fas fa-check-circle text-2xl text-green-600 mb-2"></i>
                <div class="text-lg font-bold text-dark">৳ {{ inProgressBids.length }}</div>
                <div class="text-sm text-gray-600">চলমান কাজ</div>
            </div>
            <div class="bg-purple-50 rounded-lg p-4 text-center">
                <i class="fas fa-money-bill-wave text-2xl text-purple-600 mb-2"></i>
                <div class="text-lg font-bold text-dark">৳ {{ Math.round(monthly) }}</div>
                <div class="text-sm text-gray-600">এই মাসের আয়</div>
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

                <div v-for="(bid, index) in approvedTask" :key="bid.id || index"
                    class="flex items-center p-3 border border-gray-200 rounded-lg">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-check text-green-600 text-sm"></i>
                    </div>

                    <div class="flex-1">
                        <p class="text-dark text-sm">
                            {{ bid.task?.title || 'টাস্ক' }} - বিড গ্রহণ করা হয়েছে
                        </p>

                        <p class="text-xs text-gray-600">
                            {{ formatTime(bid.created_at) }}
                        </p>
                    </div>

                    <span class="text-green-600 font-medium text-sm">
                        ৳{{ Math.round(bid.amount) }}
                    </span>
                </div>

                <div v-for="(bid, index) in appliedTask" :key="bid.id || index"
                    class="flex items-center p-3 border border-gray-200 rounded-lg">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-gavel text-blue-600 text-sm"></i>
                    </div>

                    <div class="flex-1">
                        <p class="text-dark text-sm">
                            {{ bid.task?.title || 'টাস্ক' }} - বিড করা হয়েছে
                        </p>

                        <p class="text-xs text-gray-600">
                            {{ formatTime(bid.created_at) }}
                        </p>
                    </div>

                    <span class="text-green-600 font-medium text-sm">
                        ৳{{ Math.round(bid.amount) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

</template>