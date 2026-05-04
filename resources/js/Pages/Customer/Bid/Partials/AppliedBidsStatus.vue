<script setup>
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
import { onMounted, ref } from 'vue'

const categories = ['কাজের আবেদন গুলো', 'চলামান কাজ গুলো', 'কমপ্লিটেড কাজ গুলো']

const loading=ref(false) 
const pendingBid=ref(false) 
const bidInProgress=ref(false) 
const taskCompleted=ref(false) 
const error = ref(null)

// Track which tabs have been loaded
const tabsLoaded = ref({
  pending: true, // First tab loads on mount
  inProgress: false,
  completed: false
})

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
    // Skip if already loaded
    if (tabsLoaded.value.inProgress) return
    
    loading.value = true
    try {
        const response = await axios.get(route('customer.bids.in-progress'))
        bidInProgress.value = response.data.data
        tabsLoaded.value.inProgress = true
    } catch (err) {
        error.value = 'Failed to fetch bid in progress list.'
    } finally {
        loading.value = false
    }
}

const Taskcompleted = async () => {
    // Skip if already loaded
    if (tabsLoaded.value.completed) return
    
    loading.value = true
    try {
        const response = await axios.get(route('customer.tasks.completed'))
        taskCompleted.value = response.data.data
        tabsLoaded.value.completed = true
    } catch (err) {
        error.value = 'Failed to fetch task completed list.'
    } finally {
        loading.value = false
    }
}

// Handle tab change
const handleTabChange = (index) => {
    if (index === 1 && !tabsLoaded.value.inProgress) {
        inProgress()
    } else if (index === 2 && !tabsLoaded.value.completed) {
        Taskcompleted()
    }
}

onMounted(() => {
   waitingForAcceptance()
})
</script>

<template>
    <div id="tasks" class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">আপনার কাজ সমূহ</h2>

        <TabGroup @change="handleTabChange">
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
                                {{ index === 0 ? (pendingBid ? pendingBid.length : 0) : 
                                   index === 1 ? (bidInProgress ? bidInProgress.length : 0) :
                                   (taskCompleted ? taskCompleted.length : 0) }}
                            </span>
                        </button>
                    </Tab>
                </TabList>
            </div>
            
            <TabPanels class="mt-6">
                <!-- Pending Tab (already loaded) -->
                <TabPanel>
                    <div v-if="loading && !pendingBid" class="text-center py-12">
                        <p class="text-gray-500">লোড হচ্ছে...</p>
                    </div>
                    <div v-else-if="!pendingBid || pendingBid.length === 0" class="text-center py-12">
                        <p class="text-gray-500">কোন পেন্ডিং বিড নেই</p>
                    </div>
                    <div v-else class="space-y-4">
                        <div v-for="bid in pendingBid" :key="bid.id"
                            class="border border-yellow-200 rounded-lg p-4 bg-yellow-50">
                            <!-- Rest of your pending bid template remains the same -->
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">{{ bid.task.title }}</h3>
                                    <p class="text-gray-600 text-sm">
                                        {{ bid.task.customer.name }} •
                                        {{ bid.full_address || 'এলাকা' }}
                                    </p>
                                </div>
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">
                                    বিডের পরিমাণ: ৳{{ bid.amount }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center mb-3">
                                <div class="text-sm">
                                    <span class="font-medium text-gray-800">আপনার প্রস্তাবিত মূল্য: ৳{{ bid.amount
                                        }}</span>
                                    <span class="text-gray-600 mx-2">•</span>
                                    <span class="text-gray-600">স্ট্যাটাস: {{ bid.status }}</span>
                                </div>
                                <div class="text-sm text-gray-600">
                                    <i class="fas fa-clock mr-1"></i>
                                    বিড দেওয়া: {{ new Date(bid.created_at).toLocaleDateString('bn-BD') }}
                                </div>
                            </div>

                            <div class="flex justify-end space-x-2">
                                <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50 text-sm">
                                    বিড এডিট করুন
                                </button>
                                <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                                    বিড বাতিল করুন
                                </button>
                            </div>
                        </div>
                    </div>
                </TabPanel>

                <!-- In Progress Tab (loads on click) -->
                <TabPanel>
                    <div v-if="loading && !bidInProgress && !tabsLoaded.inProgress" class="text-center py-12">
                        <p class="text-gray-500">লোড হচ্ছে...</p>
                    </div>
                    <div v-else-if="!bidInProgress || bidInProgress.length === 0" class="text-center py-12">
                        <p class="text-gray-500">কোন একসেপ্টেড বিড নেই</p>
                    </div>
                    <div v-else class="space-y-4">
                        <div v-for="bid in bidInProgress" :key="bid.id"
                            class="border border-green-200 rounded-lg p-4 bg-green-50">
                            <!-- Rest of your in-progress bid template remains the same -->
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">{{ bid.task.title }}</h3>
                                    <p class="text-gray-600 text-sm">
                                        {{ bid.task.customer.name }} •
                                        {{ bid.full_address || 'এলাকা' }}
                                    </p>
                                </div>
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                    একসেপ্টেড
                                </span>
                            </div>

                            <div class="flex justify-between items-center mb-3">
                                <div class="text-sm">
                                    <span class="font-medium text-gray-800">চুক্তির মূল্য: ৳{{ bid.amount }}</span>
                                    <span class="text-gray-600 mx-2">•</span>
                                    <span class="text-gray-600">আপনার আয়: ৳{{ Math.floor(bid.amount * 0.9) }}</span>
                                </div>
                                <div class="text-sm text-gray-600">
                                    <i class="fas fa-clock mr-1"></i>
                                    অনুমোদিত: {{ new Date(bid.updated_at).toLocaleDateString('bn-BD') }}
                                </div>
                            </div>

                            <div class="flex justify-between items-center">
                                <div class="text-sm text-gray-600">
                                    <span>গ্রাহকের যোগাযোগ: {{ bid.task.customer.phone || 'উপলব্ধ নয়' }}</span>
                                </div>
                                <div class="flex space-x-2">
                                    <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50 text-sm">
                                        <i class="fas fa-phone mr-1"></i>কল
                                    </button>
                                    <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                                        কাজ শুরু করুন
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </TabPanel>

                <!-- Completed Tab (loads on click) -->
                <TabPanel>
                    <div v-if="loading && !taskCompleted && !tabsLoaded.completed" class="text-center py-12">
                        <p class="text-gray-500">লোড হচ্ছে...</p>
                    </div>
                    <div v-else-if="!taskCompleted || taskCompleted.length === 0" class="text-center py-12">
                        <p class="text-gray-500">কোন রিজেক্টেড বিড নেই</p>
                    </div>
                    <div v-else class="space-y-4">
                        <div v-for="bid in taskCompleted" :key="bid.id"
                            class="border border-red-200 rounded-lg p-4 bg-red-50">
                            <!-- Rest of your completed task template remains the same -->
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">{{ bid.title }}</h3>
                                    <p class="text-gray-600 text-sm">
                                        {{ bid.customer.name }} •
                                        {{ bid.full_address || 'এলাকা' }}
                                    </p>
                                </div>
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm">
                                    রিজেক্টেড
                                </span>
                            </div>

                            <div class="flex justify-between items-center mb-3">
                                <div class="text-sm">
                                    <span class="font-medium text-gray-800">প্রস্তাবিত মূল্য: ৳{{ bid.amount }}</span>
                                </div>
                                <div class="text-sm text-gray-600">
                                    <i class="fas fa-clock mr-1"></i>
                                    রিজেক্টেড: {{ new Date(bid.updated_at).toLocaleDateString('bn-BD') }}
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                                    অন্যান্য কাজ দেখুন
                                </button>
                            </div>
                        </div>
                    </div>
                </TabPanel>
            </TabPanels>
        </TabGroup>
    </div>
</template>