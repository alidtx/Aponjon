<script setup>
import Pagination from '@/Components/Pagination.vue';
import Search from './Search.vue';
</script>


<template>
    <div class="lg:w-3/4">
                <Search/>
                <div class="grid grid-cols-1 gap-6">
                    <div class="bg-white rounded-lg shadow-md border-l-4 border-red-500 hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-dark mb-2">জরুরি ইলেকট্রিক মেরামত</h3>
                                    <div class="flex items-center text-sm text-gray-600 flex-wrap gap-2">
                                        <span class="flex items-center">
                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                            মিরপুর, ঢাকা
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-clock mr-1"></i>
                                            ৩০ মিনিট আগে
                                        </span>
                                        <span class="flex items-center text-red-600">
                                            <i class="fas fa-bolt mr-1"></i>
                                            ইমার্জেন্সি
                                        </span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-dark">৳১,৫০০</div>
                                    <div class="text-sm text-gray-600">বাজেট</div>
                                </div>
                            </div>

                            <p class="text-gray-700 mb-4">
                                বাসার মেইন electric line সমস্যা। পুরো ফ্ল্যাটে কারেন্ট নেই। জরুরিভাবে মেরামত প্রয়োজন।
                            </p>

                            <div class="flex justify-between items-center mb-4">
                                <div class="flex items-center space-x-4 text-sm text-gray-600">
                                    <span class="flex items-center">
                                        <i class="fas fa-gavel mr-1"></i>
                                        ৩টি বিড
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-eye mr-1"></i>
                                        ৪৫ বার দেখা
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-calendar mr-1"></i>
                                        আজ
                                    </span>
                                </div>
                            </div>

                            <div class="flex justify-between items-center">
                                <div class="flex space-x-2">
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">
                                        ইলেকট্রিক কাজ
                                    </span>
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                        <i class="fas fa-star mr-1"></i>৪.৫+ টাস্কার
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
                <Pagination/>
            </div>
</template>