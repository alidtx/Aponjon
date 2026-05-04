<script setup>
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
import { onMounted, ref } from 'vue'

const categories = ['পেন্ডিং', 'একসেপ্টেড', 'রিজেক্টেড']


const loading=ref(false) 
const pendingBid=ref(false) 
const bidInProgress=ref(false) 
const taskCompleted=ref(false) 
const error = ref(null)


const waitingForAcceptance = async () => {
    loading.value = true
    try {
        const response = await axios.get(route('customer.bids.waiting'))
        pendingBid.value = response.data.data

    } catch (err) {
        error.value = 'Failed to fetch pending bids list.'
    } finally {
        loading.value = false
    }
}

const inProgress = async () => {
    loading.value = true
    try {
        const response = await axios.get(route('customer.bids.in-progress'))
        bidInProgress.value = response.data.data

    } catch (err) {
        error.value = 'Failed to fetch bid in progress list.'
    } finally {
        loading.value = false
    }
}

const Taskcompleted = async () => {
    loading.value = true
    try {
        const response = await axios.get(route('customer.tasks.completed'))
        taskCompleted.value = response.data.data

    } catch (err) {
        error.value = 'Failed to fetch task completed list.'
    } finally {
        loading.value = false
    }
}

onMounted(()=>{
   waitingForAcceptance(); 
   inProgress(); 
   Taskcompleted()
})


</script>

<template>
    <div id="tasks" class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">আপনার কাজ সমূহ</h2>
    </div>
</template>