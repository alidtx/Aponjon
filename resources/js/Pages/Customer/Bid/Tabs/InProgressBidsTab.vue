<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    bidInProgress: {
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
        <div v-else-if="!bidInProgress || bidInProgress.length === 0" class="text-center py-12">
            <p class="text-gray-500">কোন একসেপ্টেড বিড নেই</p>
        </div>
        <div v-else class="space-y-4">
            <div v-for="bid in bidInProgress" :key="bid.id" class="border border-green-200 rounded-lg p-4 bg-green-50">
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
                    </div>
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm capitalize">
                        {{ bid.status }}
                    </span>
                </div>

                <div class="flex justify-between items-center mb-3">
                    <div class="text-sm">
                        <span class="font-medium text-gray-800">চুক্তির মূল্য: ৳ {{ Math.round(bid.amount) }}</span>
                    </div>
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-clock mr-1"></i>
                        অনুমোদিত: {{ new Date(bid.updated_at).toLocaleDateString('bn-BD') }}
                    </div>
                </div>


                <div class="flex justify-end space-x-2">
                    <Link :href="route('customer.chats.index', { user: bid.tasker.id })"
                        class="px-2 py-1 border border-gray-300 rounded bg-primary text-white  hover:bg-blue-700">
                        <i class="fas fa-comment mr-2"></i> মেসেজ পাঠান
                    </Link>
                    <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-300 text-sm">
                        বাতিল করুন
                    </button>
                    <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-300 text-sm">
                        বিতর্কিত
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>