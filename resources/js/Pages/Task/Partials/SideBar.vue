<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    tasker: {
        type: String,
        required: true
    },

    tasker_profile: {
        type: String,
        required: true
    },
     total: {
        type: Number,
        default:0
    },
     successRate: {
        type: Number,
        default:0
    }

})

const designation = computed(() => props.tasker_profile?.designation || '')
const personImage = computed(() => { return props.tasker_profile?.media?.find(item => item.name === 'Peron Image') || null }) //need to work on it
const personImagePath = computed(() => { return personImage.value?.path || '' }) //need to work on it
const rating = computed(() => props.tasker_profile?.rating || 0)
const fullStars = computed(() => Math.floor(rating.value))
const hasHalfStar = computed(() => rating.value % 1 >= 0.5)
const emptyStars = computed(() => 5 - fullStars.value - (hasHalfStar.value ? 1 : 0))


</script>

<template>
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
            <div class="text-center mb-6">
                <img src="/img/profile/dummy-image.jpg" alt="Profile"
                    class="w-20 h-20 rounded-full mx-auto mb-4">
                <h2 class="text-xl font-bold text-dark">{{ props.tasker }}</h2>
                <p class="text-gray-600 text-sm">{{ designation }}</p>
                <div class="flex justify-center space-x-1 text-yellow-400 mt-2">

                    <i v-for="n in fullStars" :key="'f' + n" class="fas fa-star"></i>
                    <i v-if="hasHalfStar" class="fas fa-star-half-alt"></i>
                    <i v-for="n in emptyStars" :key="'e' + n" class="far fa-star"></i>

                </div>
                 {{ rating.toFixed(1) }}/5.0 (৪৫ রিভিউ)
            </div>
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-sm text-gray-600">সাফল্যের হার</span>
                    <span class="text-sm font-bold text-green-600">{{ successRate }}%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">মোট আয়</span>
                    <span class="text-sm font-bold text-primary">৳ {{ Math.round(total) }}</span>
                </div>
            </div>
            <nav class="space-y-2">
                <Link :href="route('tasker.dashboard')" class="flex items-center p-3 text-primary bg-blue-50 rounded-lg font-medium"><i
                        class="fas fa-chart-pie mr-3"></i>ওভারভিউ</Link>
                 <Link class="flex items-center p-3 text-primary bg-blue-50 rounded-lg font-medium"><i
                        class="fas fa-gavel mr-3"></i>আমার বিডস</Link>
                 <Link class="flex items-center p-3 text-primary bg-blue-50 rounded-lg font-medium"><i
                        class="fas fa-tasks mr-3"></i>কাজের বিবরনী</Link>       
            </nav>
        </div>
    </div>
</template>