<script setup>
import { Head } from '@inertiajs/vue3'
import CustomerDefaultLayout from '@/Layouts/CustomerDefaultLayout.vue';
import SideBar from './Partials/SideBar.vue';
</script>


<template>
    <CustomerDefaultLayout>
        <Head title="হোম"/>
        <div class="max-w-6xl mx-auto px-4 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar -->
                <SideBar/>
                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <!-- Overview Section -->
                    <div id="overview" class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h2 class="text-2xl font-bold text-dark mb-6">ওভারভিউ</h2>

                        <!-- Stats Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div class="bg-blue-50 rounded-lg p-6 text-center">
                                <i class="fas fa-tasks text-3xl text-primary mb-3"></i>
                                <div class="text-2xl font-bold text-dark">১৫</div>
                                <div class="text-gray-600">মোট টাস্ক</div>
                            </div>
                            <div class="bg-green-50 rounded-lg p-6 text-center">
                                <i class="fas fa-check-circle text-3xl text-green-600 mb-3"></i>
                                <div class="text-2xl font-bold text-dark">১২</div>
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
                                    <div
                                        class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                        <i class="fas fa-check text-green-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-dark">ইলেকট্রিক ওয়্যারিং টাস্ক সম্পন্ন হয়েছে</p>
                                        <p class="text-sm text-gray-600">আজ সকাল ১০:৩০</p>
                                    </div>
                                    <span class="text-green-600 font-medium">৳২,৫০০</span>
                                </div>

                                <div class="flex items-center p-4 border border-gray-200 rounded-lg">
                                    <div
                                        class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4">
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

                    <!-- Active Tasks Section -->
                    <div id="tasks" class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-dark">আমার টাস্কস</h2>
                            <a href="post-task.html"
                                class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                নতুন টাস্ক
                            </a>
                        </div>

                        <!-- Tasks Tabs -->
                        <div class="border-b border-gray-200 mb-6">
                            <nav class="flex space-x-8">
                                <button class="py-2 px-1 border-b-2 border-primary text-primary font-medium">
                                    সক্রিয় (৩)
                                </button>
                                <button
                                    class="py-2 px-1 border-b-2 border-transparent text-gray-600 hover:text-gray-900">
                                    সম্পন্ন (১২)
                                </button>
                                <button
                                    class="py-2 px-1 border-b-2 border-transparent text-gray-600 hover:text-gray-900">
                                    বাতিল (০)
                                </button>
                            </nav>
                        </div>

                        <!-- Active Tasks List -->
                        <div class="space-y-4">
                            <!-- Task 1 -->
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h3 class="text-lg font-bold text-dark">বাসার প্লাম্বিং মেরামত</h3>
                                        <p class="text-gray-600 text-sm">বাথরুমের ট্যাপ লিক করছে, পাইপ replacement
                                            প্রয়োজন</p>
                                    </div>
                                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">
                                        বিড চলছে
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="text-sm text-gray-600">
                                        <span class="mr-4"><i class="fas fa-gavel mr-1"></i> ৫টি বিড</span>
                                        <span><i class="fas fa-clock mr-1"></i> ২ দিন বাকি</span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button
                                            class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm">
                                            বিড দেখুন
                                        </button>
                                        <button
                                            class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 text-sm">
                                            এডিট করুন
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Task 2 -->
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h3 class="text-lg font-bold text-dark">অফিস ক্লিনিং সার্ভিস</h3>
                                        <p class="text-gray-600 text-sm">সাপ্তাহিক অফিস ক্লিনিং, ১০০০ বর্গফুট</p>
                                    </div>
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                        টাস্কার নির্বাচিত
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="text-sm text-gray-600">
                                        <span class="mr-4"><i class="fas fa-user mr-1"></i> করিমুল ইসলাম</span>
                                        <span><i class="fas fa-calendar mr-1"></i> আগামীকাল</span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button
                                            class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm">
                                            মেসেজ
                                        </button>
                                        <button
                                            class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 text-sm">
                                            ডিটেইলস
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </CustomerDefaultLayout>
</template>