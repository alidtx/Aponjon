<script setup></script>


<template>
<div class="space-y-6">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h3 class="text-lg font-bold text-dark mb-4">এই টাস্কারকে নিয়োগ দিন</h3>
                    <div class="flex items-center justify-between mb-4 p-3 bg-green-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                            <span class="text-green-700 font-medium">এখনই উপলব্ধ</span>
                        </div>
                        <span class="text-sm text-gray-600">১০ মিনিটের মধ্যে রেসপন্স</span>
                    </div>
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">গড় রেসপন্স সময়</span>
                            <span class="font-medium">১৫ মিনিট</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">কাজ সম্পন্নের হার</span>
                            <span class="font-medium">৯৮%</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">পুনঃনিয়োগের হার</span>
                            <span class="font-medium">৭৫%</span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <button class="w-full bg-primary text-white py-3 rounded-lg hover:bg-blue-700 font-medium">
                            <i class="fas fa-comment mr-2"></i>মেসেজ পাঠান
                        </button>
                        <button class="w-full border border-primary text-primary py-3 rounded-lg hover:bg-blue-50 font-medium">
                            <i class="fas fa-gavel mr-2"></i>বিডের জন্য আমন্ত্রণ
                        </button>
                    </div>
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="font-bold text-dark mb-3">ট্রাস্ট ইন্ডিকেটরস</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>ফোন নম্বর ভেরিফাইড</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>এনআইডি ভেরিফাইড</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>ব্যাকগ্রাউন্ড চেকড</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold text-dark mb-4">কাজের নমুনা</h3>
                    <div class="grid grid-cols-2 gap-2">
                        <img src="https://via.placeholder.com/150" alt="Work 1" class="rounded-lg cursor-pointer hover:opacity-80">
                        <img src="https://via.placeholder.com/150" alt="Work 2" class="rounded-lg cursor-pointer hover:opacity-80">
                        <img src="https://via.placeholder.com/150" alt="Work 3" class="rounded-lg cursor-pointer hover:opacity-80">
                        <img src="https://via.placeholder.com/150" alt="Work 4" class="rounded-lg cursor-pointer hover:opacity-80">
                    </div>
                    <button class="w-full mt-3 text-primary hover:text-blue-700 text-sm font-medium">
                        আরও ছবি দেখুন
                    </button>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold text-dark mb-4">অনুরূপ টাস্কার</h3>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg hover:border-primary cursor-pointer">
                            <img src="https://via.placeholder.com/40" alt="Tasker" class="w-10 h-10 rounded-full">
                            <div class="flex-1">
                                <h4 class="font-medium text-dark">রফিকুল হাসান</h4>
                                <div class="flex items-center space-x-1 text-sm">
                                    <div class="flex text-yellow-400">
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                    </div>
                                    <span class="text-gray-600">৪.৮</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</template>