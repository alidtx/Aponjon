<script setup>
import Modal from '@/Components/Modal.vue';
import { Link } from '@inertiajs/vue3'
import { TailwindPagination } from 'laravel-vue-pagination'
import { ref } from 'vue'
import axios from 'axios'
import Confirm from '../Partials/Confirm.vue';
import { toast } from 'vue3-toastify';

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

const isShowModal = ref(false)
const selectedBid = ref(null)
const isProcessing = ref(false)

const acceptBid = (bid) => {
    selectedBid.value = bid
    isShowModal.value = true
}

const confirmAccept = async () => {
    if (!selectedBid.value) return
    
    isProcessing.value = true
    try {
        const response = await axios.post(route('customer.bids.accept', selectedBid.value.id))
        
        if (response.data.success) {
            isShowModal.value = false
            emit('refresh')
            toast.success('বিড সফলভাবে গ্রহণ করা হয়েছে!')
        }
    } catch (error) {
        console.error('Error accepting bid:', error)
        toast.error('বিড গ্রহণ করতে সমস্যা হয়েছে। দয়া করে আবার চেষ্টা করুন।')
    } finally {
        isProcessing.value = false
        selectedBid.value = null
    }
}

const closeModal = () => {
    if (!isProcessing.value) {
        isShowModal.value = false
        selectedBid.value = null
    }
}

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
                        প্রস্তাব করেছেন: ৳{{ Math.round(bid.amount) }}
                    </span>
                </div>

                <div class="flex justify-between items-center mb-3">
                    <div class="text-sm">
                        <span class="font-medium text-gray-800">আপনার বাজেট: ৳{{ Math.round(bid.task.budget)
                            }}</span>
                        <span class="text-gray-600 mx-2">•</span>
                        <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm capitalize">গ্রহণ করার অপেক্ষায়</span>
                    </div>
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-clock mr-1"></i>
                        বিড দেওয়া: {{ new Date(bid.created_at).toLocaleDateString('bn-BD') }}
                    </div>
                </div>

                <div class="flex justify-end space-x-2">
                    <Link :href="route('customer.chats.index', { user: bid.tasker.id })"
                        class="px-2 py-1 border border-gray-300 rounded bg-primary text-white hover:bg-blue-700">
                        <i class="fas fa-comment mr-2"></i> মেসেজ পাঠান
                    </Link>
                    <button @click="acceptBid(bid)" class="px-2 py-1 bg-green-400 text-white rounded hover:bg-green-700 text-sm">
                     <i class="fas fa-check mr-2"></i>গ্রহণ করুন
                    </button>
                </div>
            </div>
        </div>
        <div class="flex justify-center mt-8">
            <TailwindPagination :data="pendingBid" @pagination-change-page="getFilteredResults" :limit="1" />
        </div>
        
        <Modal
            :show="isShowModal"
            @close="closeModal"
            max-width="sm"
        >
            <Confirm
                :title="selectedBid?.task?.title"
                :name="selectedBid?.tasker?.name"
                :amount="selectedBid?.amount"
                :is-processing="isProcessing"
                @confirm="confirmAccept"
                @cancel="closeModal"
            /> 
        </Modal>
    </div>
</template>