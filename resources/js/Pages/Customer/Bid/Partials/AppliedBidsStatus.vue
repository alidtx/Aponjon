<script setup>
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
import { onMounted, ref } from 'vue'

const categories = ['কাজের আবেদন গুলো', 'চলামান কাজ গুলো', 'কমপ্লিটেড কাজ গুলো']


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

        <TabGroup>
            <div class="border-b border-gray-200">
                <TabList class="flex space-x-8">
                    <Tab v-for="(category, index) in categories" :key="index" v-slot="{ selected }"
                        class="focus:outline-none">
                        <button :class="[
                            'py-2 px-1 font-medium text-sm focus:outline-none border-b-2 transition-colors',
                            selected
                                ? 'border-blue-500 text-blue-600'
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                        ]">
                            {{ category }}
                            <span class="ml-2 px-2 py-0.2 text-xs rounded-full" :class="{
                                'bg-yellow-100 text-yellow-800': index === 0,
                                'bg-green-100 text-green-800': index === 1,
                                'bg-red-100 text-red-800': index === 2
                            }">
                               
                            </span>
                        </button>
                    </Tab>
                </TabList>
            </div>

           
        </TabGroup>
    </div>
</template>