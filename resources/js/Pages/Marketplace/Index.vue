<script setup>
import MarketplaceDefaultLayout from '@/Layouts/MarketplaceDefaultLayout.vue';
import { Head } from '@inertiajs/vue3'
</script>

<template>
    <MarketplaceDefaultLayout>

        <Head title="মার্কেট প্লেস" />
        <!-- Main Content -->
        <div class="lg:w-3/4">
            <!-- Sort and Search -->
            <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700">সর্বমোট <strong>১,২৫৪টি</strong> টাস্ক</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <span class="text-gray-700 mr-2">সাজান:</span>
                            <select class="border border-gray-300 rounded-lg p-2">
                                <option value="newest">নতুন প্রথম</option>
                                <option value="oldest">পুরানো প্রথম</option>
                                <option value="budget_high">বাজেট (উচ্চ থেকে низкий)</option>
                                <option value="budget_low">বাজেট (নিম্ন থেকে উচ্চ)</option>
                                <option value="urgent">জরুরি প্রথম</option>
                            </select>
                        </div>
                        <div class="relative">
                            <input type="text" placeholder="টাস্ক খুঁজুন..."
                                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg w-64">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tasks Grid -->
            <div class="grid grid-cols-1 gap-6">
                <!-- Task Card 1 - Emergency -->
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
                                <button
                                    class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 font-medium">
                                    বিড দিন
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Task Card 2 - Normal -->
                <div
                    class="bg-white rounded-lg shadow-md border-l-4 border-green-500 hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-dark mb-2">অফিস ক্লিনিং সার্ভিস</h3>
                                <div class="flex items-center text-sm text-gray-600 flex-wrap gap-2">
                                    <span class="flex items-center">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        গুলশান, ঢাকা
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-clock mr-1"></i>
                                        ২ ঘন্টা আগে
                                    </span>
                                    <span class="flex items-center text-green-600">
                                        সাধারন
                                    </span>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-dark">৳৩,০০০</div>
                                <div class="text-sm text-gray-600">বাজেট</div>
                            </div>
                        </div>

                        <p class="text-gray-700 mb-4">
                            ১০০০ বর্গফুট অফিস স্পেসের সম্পূর্ণ ক্লিনিং প্রয়োজন। ফ্লোর, উইন্ডো, ফার্নিচার এবং বাথরুম
                            ক্লিনিং।
                        </p>

                        <div class="flex justify-between items-center mb-4">
                            <div class="flex items-center space-x-4 text-sm text-gray-600">
                                <span class="flex items-center">
                                    <i class="fas fa-gavel mr-1"></i>
                                    ৭টি বিড
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-eye mr-1"></i>
                                    ৬৭ বার দেখা
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-calendar mr-1"></i>
                                    শনিবার
                                </span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <div class="flex space-x-2">
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                    ক্লিনিং সার্ভিস
                                </span>
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                    <i class="fas fa-star mr-1"></i>৪.২+ টাস্কার
                                </span>
                            </div>
                            <div class="flex space-x-2">
                                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                                    <i class="far fa-heart"></i>
                                </button>
                                <button
                                    class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 font-medium">
                                    বিড দিন
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Task Card 3 - High Budget -->
                <div
                    class="bg-white rounded-lg shadow-md border-l-4 border-purple-500 hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-dark mb-2">আইকিয়া ফার্নিচার অ্যাসেম্বলি</h3>
                                <div class="flex items-center text-sm text-gray-600 flex-wrap gap-2">
                                    <span class="flex items-center">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        বনানি, ঢাকা
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-clock mr-1"></i>
                                        ৫ ঘন্টা আগে
                                    </span>
                                    <span class="flex items-center text-orange-600">
                                        <i class="fas fa-exclamation-circle mr-1"></i>জরুরি
                                    </span>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-dark">৳৫,০০০</div>
                                <div class="text-sm text-gray-600">বাজেট</div>
                            </div>
                        </div>

                        <p class="text-gray-700 mb-4">
                            ১০+ পিস আইকিয়া ফার্নিচার অ্যাসেম্বলি প্রয়োজন। বেড, ওয়ারড্রোব, ডেস্ক, এবং বইয়ের আলমারি।
                            অভিজ্ঞ টাস্কার প্রয়োজন।
                        </p>

                        <div class="flex justify-between items-center mb-4">
                            <div class="flex items-center space-x-4 text-sm text-gray-600">
                                <span class="flex items-center">
                                    <i class="fas fa-gavel mr-1"></i>
                                    ১২টি বিড
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-eye mr-1"></i>
                                    ৮৯ বার দেখা
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-calendar mr-1"></i>
                                    আগামীকাল
                                </span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <div class="flex space-x-2">
                                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium">
                                    অ্যাসেম্বলি সার্ভিস
                                </span>
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                    <i class="fas fa-star mr-1"></i>৪.৮+ টাস্কার
                                </span>
                            </div>
                            <div class="flex space-x-2">
                                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                                    <i class="far fa-heart"></i>
                                </button>
                                <button
                                    class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 font-medium">
                                    বিড দিন
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center items-center space-x-2 mt-8">
                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="px-4 py-2 bg-primary text-white rounded-lg">1</button>
                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">2</button>
                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">3</button>
                <span class="px-2">...</span>
                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">10</button>
                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </MarketplaceDefaultLayout>
</template>