<script setup>
    import TaskerDefaultLayout from '@/Layouts/TaskerDefaultLayout.vue';
    import { Head } from '@inertiajs/vue3'
    import SideBar from './Partials/SideBar.vue';
    import Overview from './Partials/Overview.vue';
    import AssignedTask from './Partials/AssignedTask.vue';
</script>


<template>
    <TaskerDefaultLayout>
      <Head title="টাস্কার ড্যাশবোর্ড" />  
     <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
           <SideBar/>
            <div class="lg:col-span-3">
              <Overview/>
                <div id="bids" class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-dark">আমার বিডস</h2>
                        <a href="marketplace.html"
                            class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                            নতুন টাস্ক খুঁজুন
                        </a>
                    </div>
                    <div class="border-b border-gray-200 mb-6">
                        <nav class="flex space-x-8">
                            <button class="py-2 px-1 border-b-2 border-primary text-primary font-medium">
                                পেন্ডিং (৮)
                            </button>
                            <button class="py-2 px-1 border-b-2 border-transparent text-gray-600 hover:text-gray-900">
                                একসেপ্টেড (৩)
                            </button>
                            <button class="py-2 px-1 border-b-2 border-transparent text-gray-600 hover:text-gray-900">
                                রিজেক্টেড (২)
                            </button>
                            <button class="py-2 px-1 border-b-2 border-transparent text-gray-600 hover:text-gray-900">
                                সকল বিড
                            </button>
                        </nav>
                    </div>
                    <div class="space-y-4">
                        <!-- Bid 1 -->
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="text-lg font-bold text-dark">বাসার ইলেকট্রিক ওয়্যারিং</h3>
                                    <p class="text-gray-600 text-sm">ধানমন্ডি, ঢাকা • ৩ ঘন্টা আগে</p>
                                </div>
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">
                                    পেন্ডিং
                                </span>
                            </div>

                            <div class="flex justify-between items-center mb-3">
                                <div class="text-sm">
                                    <span class="font-medium text-dark">আপনার বিড: ৳২,৫০০</span>
                                    <span class="text-gray-600 mx-2">•</span>
                                    <span class="text-gray-600">গ্রাহকের বাজেট: ৳২,০০০-৳৪,০০০</span>
                                </div>
                                <div class="text-sm text-gray-600">
                                    <i class="fas fa-users mr-1"></i> ৫টি বিড
                                </div>
                            </div>

                            <div class="flex justify-between items-center">
                                <div class="text-sm text-gray-600">
                                    <span>প্রস্তাবিত সময়: ৩ ঘন্টা</span>
                                </div>
                                <div class="flex space-x-2">
                                    <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50 text-sm">
                                        এডিট বিড
                                    </button>
                                    <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                                        বিড বাতিল
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Bid 2 -->
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="text-lg font-bold text-dark">অফিস এসি সার্ভিসিং</h3>
                                    <p class="text-gray-600 text-sm">গুলশান, ঢাকা • ১ দিন আগে</p>
                                </div>
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                    Viewed
                                </span>
                            </div>

                            <div class="flex justify-between items-center mb-3">
                                <div class="text-sm">
                                    <span class="font-medium text-dark">আপনার বিড: ৳১,২০০</span>
                                    <span class="text-gray-600 mx-2">•</span>
                                    <span class="text-gray-600">গ্রাহকের বাজেট: ৳৮০০-৳১,৫০০</span>
                                </div>
                                <div class="text-sm text-gray-600">
                                    <i class="fas fa-users mr-1"></i> ৩টি বিড
                                </div>
                            </div>

                            <div class="flex justify-between items-center">
                                <div class="text-sm text-gray-600">
                                    <span>প্রস্তাবিত সময়: ২ ঘন্টা</span>
                                </div>
                                <div class="text-sm">
                                    <span class="text-green-600">গ্রাহক আপনার প্রোফাইল দেখেছেন</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              <AssignedTask/>
            </div>
        </div>
    </div>
    </TaskerDefaultLayout>
</template>      