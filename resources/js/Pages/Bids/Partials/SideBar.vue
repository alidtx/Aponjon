<script setup>
import {computed} from 'vue';
import { Link } from '@inertiajs/vue3';
import { useTimeAgo } from '@/composables/useTimeAgo'
import { useBidsAverageAmount } from '@/composables/useBidsAverageAmount';
import { findPercentage } from '@/composables/findPercentage';

const props = defineProps({
    bids: {
        type: Array,
        default: () => []
    },
    budget: {
        type: Number,
        default: 0
    },
    customerTask: {
        type: Array,
        default: () => []
    },
    totalTaskCount: {
        type: Number,
        default:0
    },
    paymentCompletionRate: {
        type: Number,
        default:0
    },
   currentTask: {
        type: Object,
        default: () => ({
            id: null,
            slug: null
        })
    }
})

const completedTaskCount = computed(() => {
    if (!Array.isArray(props.customerTask)) return 0

    return props.customerTask.filter(
        task => task?.status === 'completed'
    )
})

const successRate=findPercentage(completedTaskCount.value, props.customerTask.length)
const TaskPercentage=findPercentage(props.customerTask, props.totalTaskCount)
const average=useBidsAverageAmount(props.bids)

const lowestAmount = computed(() => {
    if (!props.bids.length) return null

    return Math.min(
        ...props.bids.map(bid => Number(bid.amount))
    )
})

const highestAmount = computed(() => {
    if (!props.bids.length) return null

    return Math.max(
        ...props.bids.map(bid => Number(bid.amount))
    )
})


</script>

<template>
    <!-- Right Column - Bid & Stats -->
    <div class="space-y-6">
        <!-- Budget & Action Card -->
        <div class="bg-white rounded-lg shadow-md p-6 animate-fade-in">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-money-bill-wave text-primary text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-dark">বাজেট</h3>
                <p class="text-3xl font-bold text-dark mt-2">৳{{ Math.round(props.budget) }}</p>
                <p class="text-gray-600 mt-1">ফিক্সড বাজেট</p>
            </div>

            <div class="space-y-4 mb-6">
                <div class="flex justify-between items-center">
                    <span class="text-gray-700">বিড সংখ্যা:</span>
                    <span class="font-bold text-dark">{{ props.bids?.length }} টি</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-700">সর্বনিম্ন বিড:</span>
                    <span class="font-bold text-green-600">৳{{ Math.round(lowestAmount) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-700">সর্বোচ্চ বিড:</span>
                    <span class="font-bold text-red-600">৳{{ Math.round(highestAmount) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-700">গড় বিড:</span>
                    <span class="font-bold text-primary">৳{{ average }}</span>
                </div>
            </div>
             
            <Link :href="route('show.bid.submit.form',{ taskId: currentTask.id, slug: currentTask.slug })"  
             class="w-full bg-primary text-white py-3 rounded-lg hover:bg-blue-700 font-medium text-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center">
              <i class="fas fa-gavel mr-3"></i>কাজের আবেদন করুন
            </Link>

            <div class="mt-4 text-center">
                <p class="text-gray-600 text-sm">
                    <i class="fas fa-shield-alt text-gray-400 mr-1"></i>
                    ১০০% সুরক্ষিত লেনদেন
                </p>
            </div>

            <div class="mt-4 flex items-center justify-center space-x-2">
                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="far fa-heart"></i>
                </button>
                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-share-alt"></i>
                </button>
                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-flag"></i>
                </button>
            </div>
        </div>

        <!-- Recent Bids -->
        <div class="bg-white rounded-lg shadow-md p-6 animate-fade-in">
            <h3 class="text-lg font-bold text-dark mb-4 flex items-center">
                <i class="fas fa-history text-primary mr-3"></i>
                সাম্প্রতিক কাজের আবেদন গুলো
            </h3>

            <div class="space-y-4 custom-scrollbar" style="max-height: 300px; overflow-y: auto;">

                <!-- If bids exist -->
                <div v-if="props.bids && props.bids.length > 0">
                    <div v-for="(bid, index) in props.bids" :key="index"
                        class="p-4 border border-gray-200 rounded-lg hover:border-primary transition-colors">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-green-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-dark">{{ bid.tasker?.name || 'Unknown' }}</p>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-star text-yellow-400 mr-1"></i>
                                        <span>৪.৯ • ৫৪ কাজ</span>
                                    </div>
                                </div>
                            </div>
                            <span class="font-bold text-green-600">৳{{ Math.round(bid.amount) }}</span>
                        </div>
                        <p class="text-gray-700 text-sm mb-2">{{ bid.proposal }}</p>
                        <div class="flex items-center text-gray-600 text-sm">
                            <i class="far fa-clock mr-1"></i>
                            <span>{{useTimeAgo(bid.created_at) }}</span>
                        </div>
                    </div>
                </div>

                <!-- If no bids -->
                <div v-else class="text-center py-8">
                    <p class="text-gray-600">এখনো কেউ আবেদন করেনি! সুযোগ হাতছাড়া না করে এখনই আবেদন করুন।</p>
                </div>

            </div>

            <!-- Show button only if more than 2 bids -->
            <button 
                class="w-full mt-4 py-2 border border-primary text-primary rounded-lg hover:bg-blue-50 font-medium transition-colors">
                সব কাজ দেখুন
            </button>
        </div>


        <!-- Client Stats -->
        <div class="bg-white rounded-lg shadow-md p-6 animate-fade-in">
            <h3 class="text-lg font-bold text-dark mb-4 flex items-center">
                <i class="fas fa-chart-line text-primary mr-3"></i>
                ক্লায়েন্ট স্ট্যাটস
            </h3>

            <div class="space-y-4">
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-gray-700 text-sm">টোটাল কাজ পোস্ট করেছেন</span>
                        <span class="font-medium text-dark text-sm">{{props.customerTask?.length}}টি</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-primary rounded-full" :style="{ width: TaskPercentage + '%' }"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-gray-700 text-sm">সফলতার হার</span>
                        <span class="font-medium text-dark text-sm">{{successRate}}%</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-green-500 rounded-full" :style="{ width: successRate  + '%' }"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-gray-700 text-sm">পেমেন্ট করার হার</span>
                        <span class="font-medium text-dark text-sm">{{paymentCompletionRate}}%</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-accent rounded-full" :style="{ width: paymentCompletionRate  + '%' }"></div>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                    <span class="text-sm text-gray-700">কন্টাক্ট নম্বর ভেরিফাইড</span>
                </div>
                <div class="flex items-center mt-2">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                    <span class="text-sm text-gray-700">ইমেইল ভেরিফাইড</span>
                </div>
            </div>
        </div>

        <!-- Safety Tips -->
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-lg p-5 animate-fade-in">
            <h3 class="text-lg font-bold text-dark mb-3 flex items-center">
                <i class="fas fa-shield-alt text-primary mr-3"></i>
                সুরক্ষা টিপস
            </h3>

            <div class="space-y-3">
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-primary mt-1 mr-3"></i>
                    <p class="text-sm text-gray-700">কাজ শুরু করার আগে লিখিত চুক্তি করুন</p>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-primary mt-1 mr-3"></i>
                    <p class="text-sm text-gray-700">গ্রাহকের পরিচয় যাচাই করুন</p>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-primary mt-1 mr-3"></i>
                    <p class="text-sm text-gray-700">পেমেন্ট লেনদেনের রেকর্ড রাখুন</p>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-primary mt-1 mr-3"></i>
                    <p class="text-sm text-gray-700">সব কাজের ছবি তোলার পরামর্শ</p>
                </div>
            </div>
        </div>
    </div>

</template>