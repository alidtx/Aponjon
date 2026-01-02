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
                                    {{ task.location }}
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-clock mr-1"></i>
                                    {{ task.created_at }}
                                </span>
                                <span v-if="task.is_urgent" class="flex items-center text-red-600">
                                    <i class="fas fa-bolt mr-1"></i>
                                    ইমার্জেন্সি
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-dark">৳{{ task.budget }}</div>
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