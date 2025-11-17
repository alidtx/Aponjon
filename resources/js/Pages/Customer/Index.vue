<script setup>
import { Head } from '@inertiajs/vue3'
import CustomerDefaultLayout from '@/Layouts/CustomerDefaultLayout.vue';
import SideBar from './Partials/SideBar/SideBar.vue';
import { ref, computed } from 'vue'

const props = defineProps({
    user: {
        type: Object,
        required: true
    },
    tasks: {
        type: Object,
        default: () => ({
            active: { data: [] },
            completed: { data: [] },
            cancelled: { data: [] }
        })
    }
})

const activeTab = ref('active')
const tasksData = computed(() => ({
    active: props.tasks.active?.data || [],
    completed: props.tasks.completed?.data || [],
    cancelled: props.tasks.cancelled?.data || []
}))

const tabCounts = computed(() => ({
    active: tasksData.value.active.length,
    completed: tasksData.value.completed.length,
    cancelled: tasksData.value.cancelled.length
}))

const currentTasks = computed(() => {
    return tasksData.value[activeTab.value] || []
})

const setActiveTab = (tab) => {
    activeTab.value = tab
}

const getStatusInfo = (task) => {
    const statusMap = {
        pending: {
            class: 'bg-yellow-100 text-yellow-800',
            text: 'বিচারাধীন'
        },
        in_progress: {
            class: 'bg-blue-100 text-blue-800',
            text: 'চলছে'
        },
        assigned: {
            class: 'bg-purple-100 text-purple-800',
            text: 'টাস্কার নির্বাচিত'
        },
        completed: {
            class: 'bg-green-100 text-green-800',
            text: 'সম্পন্ন'
        },
        cancelled: {
            class: 'bg-red-100 text-red-800',
            text: 'বাতিল'
        },
        bid_running: {
            class: 'bg-yellow-100 text-yellow-800',
            text: 'বিড চলছে'
        },
        worker_selected: {
            class: 'bg-green-100 text-green-800',
            text: 'টাস্কার নির্বাচিত'
        }
    }
    
    return statusMap[task.status] || statusMap.pending
}

const hasBids = (task) => {
    return task.bid && Array.isArray(task.bid) && task.bid.length > 0
}

 const getBidsCount = (task) => {
    if (task.bid && Array.isArray(task.bid)) {
        return task.bid.length
    }
    return 0
 }

const formatDate = (dateString) => {
    if (!dateString) return null
    try {
        const date = new Date(dateString)
        return date.toLocaleDateString('bn-BD')
    } catch (error) {
        return dateString
    }
}

const viewBids = (taskId) => {
    console.log('View bids for task:', taskId)
}

const editTask = (taskId) => {
    console.log('Edit task:', taskId)
}

const messageWorker = (taskId) => {
    console.log('Message worker for task:', taskId)
}

const viewDetails = (taskId) => {
    console.log('View details for task:', taskId)
}
</script>

<template>
    <CustomerDefaultLayout :user="props.user">
        <Head title="হোম" />
        <div class="max-w-6xl mx-auto px-4 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar -->
                <SideBar />
                
                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <!-- Overview Section -->
                    <div id="overview" class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h2 class="text-2xl font-bold text-dark mb-6">ওভারভিউ</h2>

                        <!-- Stats Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div class="bg-blue-50 rounded-lg p-6 text-center">
                                <i class="fas fa-tasks text-3xl text-primary mb-3"></i>
                                <div class="text-2xl font-bold text-dark">{{ tabCounts.active + tabCounts.completed + tabCounts.cancelled }}</div>
                                <div class="text-gray-600">মোট টাস্ক</div>
                            </div>
                            <div class="bg-green-50 rounded-lg p-6 text-center">
                                <i class="fas fa-check-circle text-3xl text-green-600 mb-3"></i>
                                <div class="text-2xl font-bold text-dark">{{ tabCounts.completed }}</div>
                                <div class="text-gray-600">সম্পন্ন টাস্ক</div>
                            </div>
                            <div class="bg-purple-50 rounded-lg p-6 text-center">
                                <i class="fas fa-star text-3xl text-purple-600 mb-3"></i>
                                <div class="text-2xl font-bold text-dark">৪.৫</div>
                                <div class="text-gray-600">গড় রেটিং</div>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div>
                            <h3 class="text-lg font-bold text-dark mb-4">সাম্প্রতিক এক্টিভিটি</h3>
                            <div class="space-y-4">
                                <div class="flex items-center p-4 border border-gray-200 rounded-lg">
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                        <i class="fas fa-check text-green-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-dark">ইলেকট্রিক ওয়্যারিং টাস্ক সম্পন্ন হয়েছে</p>
                                        <p class="text-sm text-gray-600">আজ সকাল ১০:৩০</p>
                                    </div>
                                    <span class="text-green-600 font-medium">৳২,৫০০</span>
                                </div>

                                <div class="flex items-center p-4 border border-gray-200 rounded-lg">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                        <i class="fas fa-gavel text-blue-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-dark">নতুন বিড পেয়েছেন: এসি সার্ভিসিং</p>
                                        <p class="text-sm text-gray-600">গতকাল সন্ধ্যা ৭:১৫</p>
                                    </div>
                                    <span class="text-blue-600">৩টি বিড</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tasks Section -->
                    <div id="tasks" class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-dark">আমার টাস্কস</h2>
                            <a href="post-task.html" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                নতুন টাস্ক
                            </a>
                        </div>

                        <!-- Tasks Tabs -->
                        <div class="border-b border-gray-200 mb-6">
                            <nav class="flex space-x-8">
                                <button 
                                    @click="setActiveTab('active')"
                                    :class="[
                                        'py-2 px-1 border-b-2 font-medium transition-colors',
                                        activeTab === 'active' 
                                            ? 'border-primary text-primary' 
                                            : 'border-transparent text-gray-600 hover:text-gray-900'
                                    ]"
                                >
                                    সক্রিয় ({{ tabCounts.active }})
                                </button>
                                <button 
                                    @click="setActiveTab('completed')"
                                    :class="[
                                        'py-2 px-1 border-b-2 font-medium transition-colors',
                                        activeTab === 'completed' 
                                            ? 'border-primary text-primary' 
                                            : 'border-transparent text-gray-600 hover:text-gray-900'
                                    ]"
                                >
                                    সম্পন্ন ({{ tabCounts.completed }})
                                </button>
                                <button 
                                    @click="setActiveTab('cancelled')"
                                    :class="[
                                        'py-2 px-1 border-b-2 font-medium transition-colors',
                                        activeTab === 'cancelled' 
                                            ? 'border-primary text-primary' 
                                            : 'border-transparent text-gray-600 hover:text-gray-900'
                                    ]"
                                >
                                    বাতিল ({{ tabCounts.cancelled }})
                                </button>
                            </nav>
                        </div>

                        <!-- Tasks List -->
                        <div class="space-y-4">
                            <!-- Active Tasks -->
                            <template v-if="activeTab === 'active' && currentTasks.length > 0">
                                <div 
                                    v-for="task in currentTasks" 
                                    :key="task.id"
                                    class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow"
                                >
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-bold text-dark">{{ task.title }}</h3>
                                            <p class="text-gray-600 text-sm mt-1">{{ task.description }}</p>
                                        </div>
                                        <span :class="['px-3 py-1 rounded-full text-sm whitespace-nowrap ml-4', getStatusInfo(task).class]">
                                            {{ getStatusInfo(task).text }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <div class="text-sm text-gray-600">
                                            <span v-if="hasBids(task)" class="mr-4">
                                                <i class="fas fa-gavel mr-1"></i> {{ getBidsCount(task) }}টি বিড
                                            </span>
                                            <span v-if="task.due_date" class="mr-4">
                                                <i class="fas fa-clock mr-1"></i> {{ formatDate(task.due_date) }}
                                            </span>
                                            <span v-if="task.assigned_tasker" class="mr-4">
                                                <i class="fas fa-user mr-1"></i> {{ task.assigned_tasker.name }}
                                            </span>
                                            <span v-if="task.created_at">
                                                <i class="fas fa-calendar mr-1"></i> {{ formatDate(task.created_at) }}
                                            </span>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button 
                                                v-if="hasBids(task) && task.status !== 'assigned'"
                                                @click="viewBids(task.id)"
                                                class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm"
                                            >
                                                বিড দেখুন
                                            </button>
                                            <button 
                                                v-if="task.status === 'assigned'"
                                                @click="messageWorker(task.id)"
                                                class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm"
                                            >
                                                মেসেজ
                                            </button>
                                            <button 
                                                @click="task.status === 'assigned' ? viewDetails(task.id) : editTask(task.id)"
                                                class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 text-sm"
                                            >
                                                {{ task.status === 'assigned' ? 'ডিটেইলস' : 'এডিট করুন' }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- Completed Tasks -->
                            <template v-else-if="activeTab === 'completed' && currentTasks.length > 0">
                                <div 
                                    v-for="task in currentTasks" 
                                    :key="task.id"
                                    class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow"
                                >
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-bold text-dark">{{ task.title }}</h3>
                                            <p class="text-gray-600 text-sm mt-1">{{ task.description }}</p>
                                        </div>
                                        <span :class="['px-3 py-1 rounded-full text-sm whitespace-nowrap ml-4', getStatusInfo(task).class]">
                                            {{ getStatusInfo(task).text }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <div class="text-sm text-gray-600">
                                            <span v-if="task.assigned_tasker" class="mr-4">
                                                <i class="fas fa-user mr-1"></i> {{ task.assigned_tasker.name }}
                                            </span>
                                            <span v-if="task.completed_at" class="mr-4">
                                                <i class="fas fa-calendar mr-1"></i> {{ formatDate(task.completed_at) }}
                                            </span>
                                            <span v-if="task.budget" class="text-green-600 font-medium">
                                                ৳{{ task.budget }}
                                            </span>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button 
                                                @click="viewDetails(task.id)"
                                                class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 text-sm"
                                            >
                                                ডিটেইলস
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- Cancelled Tasks -->
                            <template v-else-if="activeTab === 'cancelled' && currentTasks.length > 0">
                                <div 
                                    v-for="task in currentTasks" 
                                    :key="task.id"
                                    class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow"
                                >
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-bold text-dark">{{ task.title }}</h3>
                                            <p class="text-gray-600 text-sm mt-1">{{ task.description }}</p>
                                        </div>
                                        <span :class="['px-3 py-1 rounded-full text-sm whitespace-nowrap ml-4', getStatusInfo(task).class]">
                                            {{ getStatusInfo(task).text }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <div class="text-sm text-gray-600">
                                            <span v-if="task.cancelled_at" class="mr-4">
                                                <i class="fas fa-calendar mr-1"></i> {{ formatDate(task.cancelled_at) }}
                                            </span>
                                            <span v-if="task.cancellation_reason" class="text-red-600">
                                                কারণ: {{ task.cancellation_reason }}
                                            </span>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button 
                                                @click="viewDetails(task.id)"
                                                class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 text-sm"
                                            >
                                                ডিটেইলস
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- Empty State -->
                            <div v-else class="text-center py-8 text-gray-500">
                                {{ activeTab === 'active' ? 'কোন সক্রিয় টাস্ক নেই' : 
                                   activeTab === 'completed' ? 'কোন সম্পন্ন টাস্ক নেই' : 
                                   'কোন বাতিল টাস্ক নেই' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </CustomerDefaultLayout>
</template>