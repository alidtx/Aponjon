<script setup>
import { Link } from '@inertiajs/vue3';
import Disputed from '../Partials/Disputed.vue';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';
import axios from 'axios';
import { toast } from 'vue3-toastify';

const props = defineProps({
    bidInprogress: {
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

const emit = defineEmits(['refresh'])

const isShowDisputedModal = ref(false)
const selectedBid = ref(null)
const isProcessing = ref(false)
const errors = ref({})
const modalKey = ref(0)

const disputed = (bid) => {
    selectedBid.value = bid
    errors.value = {}
    modalKey.value++
    isShowDisputedModal.value = true
}

const confirmDisputed = async (disputeReason) => {
    if (!selectedBid.value) return

    isProcessing.value = true
    errors.value = {}

    try {
        const response = await axios.post(route('customer.bids.dispute', selectedBid.value.id), {
            dispute_reason: disputeReason
        })

        if (response.data.success) {
            isShowDisputedModal.value = false
            emit('refresh') // Refresh the list
            toast.success('বিডটি সফলভাবে বিতর্কিত করা হয়েছে!')
            selectedBid.value = null
        }
    } catch (error) {
        if (error.response?.status === 422) {
            errors.value = error.response.data.errors
            return // Don't close modal, let user fix
        }
        toast.error('সমস্যা হয়েছে, আবার চেষ্টা করুন')
        isShowDisputedModal.value = false
        selectedBid.value = null
    } finally {
        isProcessing.value = false
    }
}

const closeModal = () => {
    if (!isProcessing.value) {
        isShowDisputedModal.value = false
        selectedBid.value = null
        errors.value = {}
    }
}

const statusLabel = (status) => {
    return {
        in_progress: 'কাজ চলমান',
        disputed: 'বিতর্কিত',
    }[status] || 'অজানা';
}
</script>

<template>
    <div>
        <div v-if="loading && !isLoading" class="text-center py-12">
            <p class="text-gray-500">লোড হচ্ছে...</p>
        </div>
        <div v-else-if="!bidInprogress || bidInprogress.length === 0" class="text-center py-12">
            <p class="text-gray-500">কাজ চলমান নেই</p>
        </div>
        <div v-else class="space-y-4">
            <div v-for="bid in bidInprogress" :key="bid.id" class="border border-blue-200 rounded-lg p-4 bg-blue-50">
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
                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">
                        {{ statusLabel(bid.task.status) }}
                    </span>
                </div>

                <div class="flex justify-between items-center mb-3">
                    <div class="text-sm">
                        <span class="font-medium text-gray-800">চুক্তির মূল্য: ৳ {{ Math.round(bid.amount) }}</span>
                    </div>
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-clock mr-1"></i>
                        শুরু: {{ new Date(bid.updated_at).toLocaleDateString('bn-BD') }}
                    </div>
                </div>
                <div class="flex justify-end space-x-2">
                    <Link :href="route('customer.chats.index', { user: bid.tasker.id })"
                        class="px-2 py-1 border border-gray-300 rounded bg-primary text-white hover:bg-blue-700">
                        <i class="fas fa-comment mr-2"></i> মেসেজ পাঠান
                    </Link>
                    <button v-if="bid.task.status !== 'disputed'" @click="disputed(bid)"
                        class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                        <i class="fas fa-exclamation-triangle mr-1"></i>বিতর্কিত
                    </button>
                </div>
            </div>
        </div>

        <Modal :show="isShowDisputedModal" @close="closeModal" max-width="sm">
            <Disputed :key="modalKey" :title="selectedBid?.task?.title" :name="selectedBid?.tasker?.name"
                :amount="selectedBid?.amount" :is-processing="isProcessing" :errors="errors" @confirm="confirmDisputed"
                @cancel="closeModal" />
        </Modal>
    </div>
</template>