<script setup>
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'

const categories = ['চলমান', 'অ্যাসাইনড', 'সম্পন্ন', 'বিতর্কিত']

const props = defineProps({
    inProgressTasks: {
        type: Array,
        default: () => []
    },
    assignedTasks: {
        type: Array,
        default: () => []
    },
    completedTasks: {
        type: Array,
        default: () => []
    },
    disputedTasks: {
        type: Array,
        default: () => []
    },
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
                                'bg-green-100 text-green-800': index === 0,
                                'bg-blue-100 text-blue-800': index === 1,
                                'bg-gray-100 text-gray-800': index === 2,
                                'bg-red-100 text-red-800': index === 3
                            }">
                                {{ index === 0 ? inProgressTasks.data.length : 
                                   index === 1 ? assignedTasks.data.length : 
                                   index === 2 ? completedTasks.data.length : 
                                   disputedTasks.data.length }}
                            </span>
                        </button>
                    </Tab>
                </TabList>
            </div>

            <TabPanels class="mt-6">
                <!-- In Progress Tab -->
                <TabPanel>
                    <div v-if="inProgressTasks.data.length === 0" class="text-center py-12">
                        <p class="text-gray-500">কোন চলমান কাজ নেই</p>
                    </div>
                    <div v-else class="space-y-4">
                        <div v-for="bid in inProgressTasks.data" :key="bid.id"
                            class="border border-green-200 rounded-lg p-4 bg-green-50">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">{{ bid.task?.title || 'কাজের শিরোনাম নেই' }}</h3>
                                    <p class="text-gray-600 text-sm">
                                        {{ bid.task?.customer?.name || 'ক্লায়েন্ট' }} •
                                        {{ bid.full_address || bid.task?.customers?.customerProfile?.full_address || 'এলাকা' }}
                                    </p>
                                </div>
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                    চলমান
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
                                    শুরু করেছেন: {{ new Date(bid.updated_at).toLocaleDateString('bn-BD') }}
                                </div>
                            </div>

                            <div class="mb-3" v-if="bid.proposal">
                                <p class="text-sm text-gray-700">
                                    <span class="font-medium">বিবরণ:</span> {{ bid.proposal }}
                                </p>
                            </div>

                            <div class="flex justify-between items-center">
                                <div class="text-sm text-gray-600">
                                    <span>গ্রাহকের যোগাযোগ: {{ bid.task?.customer?.phone || 'উপলব্ধ নয়' }}</span>
                                </div>
                                <div class="flex space-x-2">
                                    <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50 text-sm">
                                        <i class="fas fa-phone mr-1"></i>কল
                                    </button>
                                    <button class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 text-sm">
                                        <i class="fas fa-check mr-1"></i>সম্পন্ন করুন
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </TabPanel>

                <!-- Assigned Tab -->
                <TabPanel>
                    <div v-if="assignedTasks.data.length === 0" class="text-center py-12">
                        <p class="text-gray-500">কোন অ্যাসাইনড কাজ নেই</p>
                    </div>
                    <div v-else class="space-y-4">
                        <div v-for="bid in assignedTasks.data" :key="bid.id"
                            class="border border-blue-200 rounded-lg p-4 bg-blue-50">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">{{ bid.task?.title || 'কাজের শিরোনাম নেই' }}</h3>
                                    <p class="text-gray-600 text-sm">
                                        {{ bid.task?.customer?.name || 'ক্লায়েন্ট' }} •
                                        {{ bid.full_address || bid.task?.customers?.customerProfile?.full_address || 'এলাকা' }}
                                    </p>
                                </div>
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                    অ্যাসাইনড
                                </span>
                            </div>

                            <div class="flex justify-between items-center mb-3">
                                <div class="text-sm">
                                    <span class="font-medium text-gray-800">চুক্তির মূল্য: ৳{{ bid.amount }}</span>
                                    <span class="text-gray-600 mx-2">•</span>
                                    <span class="text-gray-600">আপনার আয়: ৳{{ Math.floor(bid.amount * 0.9) }}</span>
                                </div>
                                <div class="text-sm text-gray-600" v-if="bid.specific_date">
                                    <i class="fas fa-calendar mr-1"></i>
                                    নির্ধারিত তারিখ: {{ new Date(bid.specific_date).toLocaleDateString('bn-BD') }}
                                </div>
                            </div>

                            <div class="mb-3" v-if="bid.proposal">
                                <p class="text-sm text-gray-700">
                                    <span class="font-medium">প্রস্তাবনা:</span> {{ bid.proposal }}
                                </p>
                            </div>

                            <div class="flex justify-between items-center">
                                <div class="text-sm text-gray-600">
                                    <span>গ্রাহকের যোগাযোগ: {{ bid.task?.customer?.phone || 'উপলব্ধ নয়' }}</span>
                                </div>
                                <div class="flex space-x-2">
                                    <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50 text-sm">
                                        <i class="fas fa-phone mr-1"></i>কল
                                    </button>
                                    <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                                        <i class="fas fa-play mr-1"></i>কাজ শুরু করুন
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </TabPanel>

                <!-- Completed Tab -->
                <TabPanel>
                    <div v-if="completedTasks.data.length === 0" class="text-center py-12">
                        <p class="text-gray-500">কোন সম্পন্ন কাজ নেই</p>
                    </div>
                    <div v-else class="space-y-4">
                        <div v-for="bid in completedTasks.data" :key="bid.id"
                            class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">{{ bid.task?.title || 'কাজের শিরোনাম নেই' }}</h3>
                                    <p class="text-gray-600 text-sm">
                                        {{ bid.task?.customer?.name || 'ক্লায়েন্ট' }} •
                                        {{ bid.full_address || bid.task?.customers?.customerProfile?.full_address || 'এলাকা' }}
                                    </p>
                                </div>
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm">
                                    সম্পন্ন
                                </span>
                            </div>

                            <div class="flex justify-between items-center mb-3">
                                <div class="text-sm">
                                    <span class="font-medium text-gray-800">মোট আয়: ৳{{ Math.floor(bid.amount * 0.9) }}</span>
                                </div>
                                <div class="text-sm text-gray-600">
                                    <i class="fas fa-check-circle mr-1 text-green-600"></i>
                                    সম্পন্ন হয়েছে: {{ new Date(bid.updated_at).toLocaleDateString('bn-BD') }}
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button class="px-3 py-1 bg-gray-500 text-white rounded hover:bg-gray-600 text-sm">
                                    <i class="fas fa-star mr-1"></i>রিভিউ দেখুন
                                </button>
                            </div>
                        </div>
                    </div>
                </TabPanel>

                <!-- Disputed Tab -->
                <TabPanel>
                    <div v-if="disputedTasks.data.length === 0" class="text-center py-12">
                        <p class="text-gray-500">কোন বিতর্কিত কাজ নেই</p>
                    </div>
                    <div v-else class="space-y-4">
                        <div v-for="bid in disputedTasks.data" :key="bid.id"
                            class="border border-red-200 rounded-lg p-4 bg-red-50">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">{{ bid.task?.title || 'কাজের শিরোনাম নেই' }}</h3>
                                    <p class="text-gray-600 text-sm">
                                        {{ bid.task?.customer?.name || 'ক্লায়েন্ট' }} •
                                        {{ bid.full_address || bid.task?.customer?.customerProfile?.full_address || 'এলাকা' }}
                                    </p>
                                </div>
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm">
                                    বিতর্কিত
                                </span>
                            </div>

                            <div class="flex justify-between items-center mb-3">
                                <div class="text-sm">
                                    <span class="font-medium text-gray-800">চুক্তির মূল্য: ৳{{ bid.amount }}</span>
                                </div>
                                <div class="text-sm text-gray-600">
                                    <i class="fas fa-exclamation-triangle mr-1 text-red-600"></i>
                                    বিতর্ক উত্থাপিত: {{ new Date(bid.updated_at).toLocaleDateString('bn-BD') }}
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                                    <i class="fas fa-gavel mr-1"></i>বিবাদ সমাধান
                                </button>
                            </div>
                        </div>
                    </div>
                </TabPanel>
            </TabPanels>
        </TabGroup>
    </div>
</template>