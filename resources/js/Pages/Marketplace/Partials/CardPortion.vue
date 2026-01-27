<script setup>
import Search from './Search.vue';
import PageLoader from '@/Components/PageLoader.vue';
import { ref, provide } from 'vue'
import { router } from '@inertiajs/vue3'
import { TailwindPagination } from 'laravel-vue-pagination'
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    cardData: {
        type: Object,
        required: true
    },
})


const perPage = ref(props.cardData?.per_page ?? 15)
const isLoading = ref(false)
const handleLoadingChange = (loading) => {
    isLoading.value = loading
}

const getFilteredResults = (page = 1) => {
    isLoading.value = true
    router.visit(route('marketplace'), {
        data: {
            page: page,
            per_page: parseInt(perPage.value),
        },
        preserveScroll: true,
        onFinish: () => {
            isLoading.value = false
        }
    })
}

const refreshSearch = () => {
    // This will be set by the Search component
}

provide('refreshSearch', refreshSearch)

const getLocation = (task) => {
    return [
        task.district?.name,
        task.zila?.name,
        task.upozila?.name
    ].filter(Boolean).join(', ')
}

const timeAgo = (dateTime) => {
    if (!dateTime) return ''

    const now = new Date()
    const past = new Date(dateTime.replace(' ', 'T'))
    const diffSeconds = Math.floor((now - past) / 1000)

    if (diffSeconds < 60) {
        return `${diffSeconds} সেকেন্ড আগে`
    }

    const diffMinutes = Math.floor(diffSeconds / 60)
    if (diffMinutes < 60) {
        return `${diffMinutes} মিনিট আগে`
    }

    const diffHours = Math.floor(diffMinutes / 60)
    if (diffHours < 24) {
        return `${diffHours} ঘন্ট আগে`
    }

    const diffDays = Math.floor(diffHours / 24)
    return `${diffDays} দিন আগে`
}

const URGENCY_MAP = {
    normal: {
        text: 'সাধারণ',
        icon: 'fa-circle',
        border: 'border-green-600',
        textColor: 'text-green-600',
        bgColor: 'bg-green-100',
    },
    urgent: {
        text: 'জরুরি',
        icon: 'fa-exclamation-circle',
        border: 'border-yellow-500',
        textColor: 'text-yellow-600',
        bgColor: 'bg-yellow-100',
    },
    emergency: {
        text: 'ইমার্জেন্সি',
        icon: 'fa-bolt',
        border: 'border-red-600',
        textColor: 'text-red-600',
        bgColor: 'bg-red-100',
    },
    other: {
        text: 'অন্যান্য',
        icon: 'fa-info-circle',
        border: 'border-blue-500',
        textColor: 'text-blue-600',
        bgColor: 'bg-blue-100',
    },
}

const urgency = (value = '') => URGENCY_MAP[value.toLowerCase()] || URGENCY_MAP.normal
</script>

<template>
    <div class="lg:w-3/4 relative">
        <PageLoader :loading="isLoading" />
        <Search @loading-change="handleLoadingChange" />
        <div class="relative">
            <div v-if="isLoading && (!cardData.data || cardData.data.length === 0)" class="grid grid-cols-1 gap-6">
                <div v-for="n in 3" :key="n" class="bg-gray-100 rounded-lg shadow animate-pulse h-48"></div>
            </div>
            <div v-else-if="cardData.data && cardData.data.length > 0" class="grid grid-cols-1 gap-6">
                <div v-for="(task, index) in cardData.data" :key="index" :class="[
                    'bg-white rounded-lg shadow-md border-l-4 hover:shadow-lg transition-shadow duration-300',
                    urgency(task.emergency).border
                ]">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-dark mb-2">{{ task.title }}</h3>
                                <div class="flex items-center text-sm text-gray-600 flex-wrap gap-2">
                                    <span class="flex items-center">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        {{ getLocation(task) }}
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ timeAgo(task.created_at) }}
                                    </span>
                                    <span class="flex items-cente" :class="urgency(task.emergency).textColor">
                                        <i class="fas mr-1" :class="urgency(task.emergency).icon"></i>
                                        {{ urgency(task.emergency).text }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-dark">৳{{ Math.round(task.budget) }}</div>
                                <div class="text-sm text-gray-600">বাজেট</div>
                            </div>
                        </div>

                        <p class="text-gray-700 mb-4">
                            {{ task.description }}
                        </p>

                        <div class="flex justify-between items-center mb-4">
                            <div class="flex items-center space-x-4 text-sm text-gray-600">
                                <span class="flex items-center">
                                    <i class="fas fa-gavel mr-1"></i>
                                    {{ task.bids_count || 0 }}টি বিড
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-eye mr-1"></i>
                                    {{ task.views || 0 }} বার দেখা
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ task.due_date }}
                                </span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <div class="flex space-x-2">
                                <span class=" px-3 py-1 rounded-full text-sm font-medium"
                                    :class="urgency(task.emergency).bgColor, urgency(task.emergency).textColor">
                                    {{ task.category?.name || 'সাধারণ' }}
                                </span>
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                    <i class="fas fa-star mr-1"></i>8.5+ টাস্কার
                                </span>
                            </div>
                            <div class="flex space-x-2">
                                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                                    <i class="far fa-heart"></i>
                                </button>
                                <Link :href="route('tasks.show',{ taskId: task.id, slug: task.slug })" 
                                    class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 font-medium">
                                    বিস্তারিত দেখুন
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="text-center py-8">
                <p class="text-gray-600">কোন টাস্ক পাওয়া যায়নি।</p>
            </div>
        </div>
        <div class="flex justify-center items-center space-x-2 mt-8">
            <TailwindPagination :data="props.cardData" @pagination-change-page="getFilteredResults" :limit="1"
                class="mx-5" />
        </div>
    </div>
</template>