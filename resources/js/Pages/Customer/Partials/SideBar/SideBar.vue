<script setup>

</script>


<template>
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
            <!-- Profile Summary -->
            <div class="text-center mb-6">
                <img src="https://via.placeholder.com/80" alt="Profile" class="w-20 h-20 rounded-full mx-auto mb-4">
                <h2 class="text-xl font-bold text-dark">রহিমা আক্তার</h2>
                <p class="text-gray-600 text-sm">সদস্য since মার্চ ২০২৪</p>
                <div class="flex justify-center space-x-1 text-yellow-400 mt-2">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <span class="text-sm text-gray-600">৪.৫ (১২ রিভিউ)</span>
            </div>

            <!-- Navigation Menu -->
            <nav class="space-y-2">
                <a href="#overview" class="flex items-center p-3 text-primary bg-blue-50 rounded-lg font-medium">
                    <i class="fas fa-chart-pie mr-3"></i>
                    ওভারভিউ
                </a>
                <a href="#tasks" class="flex items-center p-3 text-gray-700 hover:bg-gray-50 rounded-lg">
                    <i class="fas fa-tasks mr-3"></i>
                    আমার টাস্কস
                </a>
                <a href="#bids" class="flex items-center p-3 text-gray-700 hover:bg-gray-50 rounded-lg">
                    <i class="fas fa-gavel mr-3"></i>
                    বিড ম্যানেজমেন্ট
                </a>
                <a href="#messages" class="flex items-center p-3 text-gray-700 hover:bg-gray-50 rounded-lg">
                    <i class="fas fa-comments mr-3"></i>
                    মেসেজেস
                </a>
                <a href="#payments" class="flex items-center p-3 text-gray-700 hover:bg-gray-50 rounded-lg">
                    <i class="fas fa-credit-card mr-3"></i>
                    পেমেন্টস
                </a>
                <a href="#reviews" class="flex items-center p-3 text-gray-700 hover:bg-gray-50 rounded-lg">
                    <i class="fas fa-star mr-3"></i>
                    রিভিউস
                </a>
                <a href="#settings" class="flex items-center p-3 text-gray-700 hover:bg-gray-50 rounded-lg">
                    <i class="fas fa-cog mr-3"></i>
                    সেটিংস
                </a>
            </nav>
        </div>
    </div>
</template>