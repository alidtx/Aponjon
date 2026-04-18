<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';



const props = defineProps({

    profile: {
        type: Object,
        default: () => ({})
    }

})

const userName = computed(() => props.profile.data?.name || '')
// const designation = computed(() => props.profile.data?.tasker_profile.designation || '')
console.log(props.profile)


</script>

<template>
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
            <div class="text-center mb-6">
                <img src="https://www.twtf.org.uk/wp-content/uploads/2024/01/dummy-image.jpg" alt="Profile"
                    class="w-20 h-20 rounded-full mx-auto mb-4">
                <h2 class="text-xl font-bold text-dark">{{ userName }}</h2>
                <p class="text-gray-600 text-sm">ইলেকট্রিশিয়ান</p>
                <div class="flex justify-center space-x-1 text-yellow-400 mt-2">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <span class="text-sm text-gray-600">৪.৫/৫.০ (৪৫ রিভিউ)</span>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-sm text-gray-600">সাফল্যের হার</span>
                    <span class="text-sm font-bold text-green-600">৯২%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">মোট আয়</span>
                    <span class="text-sm font-bold text-primary">৳১,২৫,৪০০</span>
                </div>
            </div>
            <nav class="space-y-2">
                <Link class="flex items-center p-3 text-primary bg-blue-50 rounded-lg font-medium"><i
                        class="fas fa-chart-pie mr-3"></i>ওভারভিউ</Link>
            </nav>
        </div>
    </div>
</template>