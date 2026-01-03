<script setup>
import Pagination from '@/Components/Pagination.vue';
import Search from './Search.vue';
import { watch } from 'vue'

const props = defineProps({
    cardData: {
        type: Array,
        required: true
    }
})

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
const urgency = (urgency) => {
    const value = (urgency || '').toString().toLowerCase()

    if (value === 'normal') {
        return { text: 'সাধারণ', icon: 'fa-circle text-green-400', textColor: 'text-green-600' }
    }

    if (value === 'urgent') {
        return { text: 'জরুরি', icon: 'fa-exclamation-circle text-yellow-500', textColor: 'text-orange-600' }
    }

    if (value === 'emergency') {
        return { text: 'ইমার্জেন্সি', icon: 'fa-bolt text-red-600', textColor: 'text-red-600' }
    }

    if (value === 'other') {
        return { text: 'অন্যান্য', icon: 'fa-info-circle text-blue-500', textColor: 'text-blue-600' }
    }

    return { text: 'সাধারণ', icon: 'fa-circle text-gray-400', textColor: 'text-red-600' }
}



console.log(props.cardData);
</script>


<template>
    <div class="lg:w-3/4">
        <Search />
        <div v-if="!cardData || cardData.length === 0" class="text-center py-8">
            <p class="text-gray-600">লোড হচ্ছে বা কোন ডেটা নেই...</p>
        </div>
        <div v-else class="grid grid-cols-1 gap-6">
            <div v-for="(task, index) in cardData" :key="index"
                class="bg-white rounded-lg shadow-md border-l-4 border-red-500 hover:shadow-lg transition-shadow">
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
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">
                                {{ task.category?.name || 'সাধারণ' }}
                            </span>
                            <span v-if="task.user?.rating"
                                class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                <i class="fas fa-star mr-1"></i>{{ task.user.rating }}+ টাস্কার
                            </span>
                        </div>
                        <div class="flex space-x-2">
                            <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                                <i class="far fa-heart"></i>
                            </button>
                            <button class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 font-medium">
                                বিড দিন
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Pagination />
    </div>
</template>