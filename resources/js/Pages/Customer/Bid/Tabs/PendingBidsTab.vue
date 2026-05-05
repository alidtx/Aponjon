<script setup>
import { Link } from '@inertiajs/vue3'
import { TailwindPagination } from 'laravel-vue-pagination'

const props = defineProps({
    pendingBid: {
        type: Array,
        required: true
    },
    loading: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['accept-bid', 'refresh'])

const getFilteredResults = (pageNumber = 1) => {
    emit('refresh', pageNumber)
}
</script>

<template>
    <div>
        <div v-if="loading && !pendingBid" class="text-center py-12">
            <p class="text-gray-500">লোড হচ্ছে...</p>
        </div>
        <div v-else-if="!pendingBid || pendingBid.length === 0" class="text-center py-12">
            <p class="text-gray-500">কোন পেন্ডিং বিড নেই</p>
        </div>
        <div v-else class="space-y-4">
            <div v-for="bid in pendingBid" :key="bid.id" class="border border-yellow-200 rounded-lg p-4 bg-yellow-50">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">{{ bid.task.title }}</h3>
                        <p class="text-gray-600 text-sm flex items-center gap-2 py-1">
                            <img :src="bid.tasker.tasker_profile?.profile_photo || '/img/profile/dummy-image.jpg'"
                                :alt="bid.tasker.name" class="w-6 h-6 rounded-full object-cover">

                            <span>
                                <Link :href="route('tasker.public.profile', bid.tasker.id)"
                                    class="text-blue-500 hover:text-blue-700 hover:underline">{{
                                        bid.tasker.name }}
                                    <i class="fas fa-external-link-alt text-xs"></i>
                                </Link> •
                                {{ bid.tasker.tasker_profile?.full_address || 'এলাকা' }}
                            </span>
                        </p>
                        <p class="text-gray-600 text-sm">Here Home: address will be added and will come from
                            tasker
                            profile table</p>
                    </div>
                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">
                        প্রস্তাতাব করেছেন: ৳{{ Math.round(bid.amount) }}
                    </span>
                </div>

                <div class="flex justify-between items-center mb-3">
                    <div class="text-sm">
                        <span class="font-medium text-gray-800">আপনার বাজেট: ৳{{ Math.round(bid.task.budget)
                            }}</span>
                        <span class="text-gray-600 mx-2">•</span>
                        <span class=" font-semibold text-yellow-600">স্ট্যাটাস: {{ bid.status }}</span>
                    </div>
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-clock mr-1"></i>
                        বিড দেওয়া: {{ new Date(bid.created_at).toLocaleDateString('bn-BD') }}
                    </div>
                </div>

                <div class="flex justify-end space-x-2">
                    <Link :href="route('customer.chats.index', { user: bid.tasker.id })"
                        class="px-2 py-1 border border-gray-300 rounded bg-primary text-white  hover:bg-blue-700">
                        <i class="fas fa-comment mr-2"></i> মেসেজ পাঠান
                    </Link>
                    <button class="px-3 py-1 bg-green-500 text-white rounded hover:bg-red-600 text-sm">
                        একচেপ্ট করুন
                    </button>
                </div>
            </div>
        </div>
        <div class="flex justify-center mt-8">
            <TailwindPagination :data="pendingBid" @pagination-change-page="getFilteredResults" :limit="1" />
        </div>
    </div>
</template>