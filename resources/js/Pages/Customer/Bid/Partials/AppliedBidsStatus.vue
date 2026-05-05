<script setup>
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
import { onMounted, ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import { TailwindPagination } from 'laravel-vue-pagination'

const categories = ['কাজের আবেদন গুলো', 'চলামান কাজ গুলো', 'কমপ্লিটেড কাজ গুলো']

const loading = ref(false)
const pendingBid = ref([])
const bidInProgress = ref([])
const taskCompleted = ref([])
const perPage = ref(5)
const error = ref(null)

const tabsLoaded = ref({
    pending: true,
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

const handleTabChange = (index) => {
    if (index === 1 && !tabsLoaded.value.inProgress) {
        inProgress()
    } else if (index === 2 && !tabsLoaded.value.completed) {
        Taskcompleted()
    }
}


const getFilteredResults = (pageNumber = 1) => {
    isLoading.value = true

    router.get(route('customer.bids.waiting'), {
        page: pageNumber,
        per_page: perPage.value,
    }, {
        preserveScroll: true,
        preserveState: true,
        onFinish: () => {
            isLoading.value = false
        }
    })
}
onMounted(() => {
    waitingForAcceptance()
})
</script>

<template>
    <div id="tasks" class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">আবেদনকৃত কাজসমূহ</h2>

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
                                <template v-if="index === 0">
                                    {{ pendingBid.length }}
                                </template>
                                <template v-else-if="index === 1">
                                    {{ tabsLoaded.inProgress ? bidInProgress.length : '?' }}
                                </template>
                                <template v-else>
                                    {{ tabsLoaded.completed ? taskCompleted.length : '?' }}
                                </template>
                            </span>
                        </button>
                    </Tab>
                </TabList>
            </div>

            <TabPanels class="mt-6">

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
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">{{ bid.task.title }}</h3>
                                    <p class="text-gray-600 text-sm flex items-center gap-2 py-1">
                                        <img :src="bid.tasker.tasker_profile?.profile_photo || '/img/profile/dummy-image.jpg'" :alt="bid.tasker.name"
                                            class="w-6 h-6 rounded-full object-cover">

                                        <span>
                                            <Link :href="route('tasker.public.profile',bid.tasker.id)" class="text-blue-500">{{ bid.tasker.name }}</Link> •
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
                                    class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50 text-sm">
                                    মেসেজ পাঠান
                                </Link>
                                <button class="px-3 py-1 bg-green-500 text-white rounded hover:bg-red-600 text-sm">
                                    একচেপ্ট করুন
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center mt-8">
                        <TailwindPagination :data="pendingBid" @pagination-change-page="getFilteredResults"
                            :limit="1" />
                    </div>
                </TabPanel>

                <TabPanel>
                    <div v-if="loading && !tabsLoaded.inProgress" class="text-center py-12">
                        <p class="text-gray-500">লোড হচ্ছে...</p>
                    </div>
                    <div v-else-if="!bidInProgress || bidInProgress.length === 0" class="text-center py-12">
                        <p class="text-gray-500">কোন একসেপ্টেড বিড নেই</p>
                    </div>
                    <div v-else class="space-y-4">
                        <div v-for="bid in bidInProgress" :key="bid.id"
                            class="border border-green-200 rounded-lg p-4 bg-green-50">
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
                                        মেসেজ দিন
                                    </button>
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
                </TabPanel>

                <TabPanel>
                    <div v-if="loading && !tabsLoaded.completed" class="text-center py-12">
                        <p class="text-gray-500">লোড হচ্ছে...</p>
                    </div>
                    <div v-else-if="!taskCompleted || taskCompleted.length === 0" class="text-center py-12">
                        <p class="text-gray-500">কোন রিজেক্টেড বিড নেই</p>
                    </div>
                    <div v-else class="space-y-4">
                        <div v-for="bid in taskCompleted" :key="bid.id"
                            class="border border-red-200 rounded-lg p-4 bg-red-50">
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
                                    রিবিউ দিন
                                </button>
                            </div>
                        </div>

                    </div>
                </TabPanel>
            </TabPanels>
        </TabGroup>
    </div>
</template>