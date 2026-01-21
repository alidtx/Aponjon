<script setup>


</script>


<template>
            <div class="lg:col-span-2 space-y-6">
                <!-- Task Header - SheiShohoj Style -->
                <div class="bg-white rounded-lg shadow-md border-l-4 border-emergency animate-fade-in">
                    <div class="p-6">
                        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                            <div class="flex items-center space-x-3">
                                <span class="status-emergency px-4 py-1.5 rounded-full text-sm font-medium">
                                    <i class="fas fa-bolt mr-2"></i>ইমার্জেন্সি
                                </span>
                                <span class="category-electrical px-4 py-1.5 rounded-full text-sm font-medium">
                                    <i class="fas fa-bolt mr-2"></i>ইলেকট্রিক কাজ
                                </span>
                            </div>
                            
                            <div class="flex items-center space-x-4 text-sm text-gray-600">
                                <span class="flex items-center">
                                    <i class="far fa-eye mr-1"></i>
                                    ২৪৫ বার দেখা
                                </span>
                                <span class="flex items-center">
                                    <i class="far fa-clock mr-1"></i>
                                    ৩০ মিনিট আগে
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-gavel mr-1"></i>
                                    ১২টি বিড
                                </span>
                            </div>
                        </div>
                        
                        <h1 class="text-3xl font-bold text-dark mb-4">বাসার ইলেকট্রিক ওয়্যারিং</h1>
                        
                        <div class="flex items-center text-gray-700 mb-6">
                            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-user-circle text-gray-500 text-2xl"></i>
                            </div>
                            <div>
                                <p class="font-medium text-dark">আরিফ আহমেদ</p>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    <span>মিরপুর, ঢাকা</span>
                                    <i class="fas fa-star text-yellow-400 ml-4 mr-1"></i>
                                    <span>৪.৮ (১২৩ রিভিউ)</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Urgent Info Box -->
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-red-600 text-xl mr-3"></i>
                                <div>
                                    <p class="font-medium text-red-800">জরুরি কাজ</p>
                                    <p class="text-red-700 text-sm">গ্রাহক কাজটি আজই শেষ করতে চান। যত দ্রুত সম্ভব শুরু করুন।</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Task Description -->
                <div class="bg-white rounded-lg shadow-md p-6 animate-fade-in">
                    <h2 class="text-xl font-bold text-dark mb-4 flex items-center">
                        <i class="fas fa-align-left text-primary mr-3"></i>
                        টাস্ক বিবরণ
                    </h2>
                    
                    <div class="prose max-w-none text-gray-700 mb-6">
                        <p class="mb-4">আমার নতুন ফ্ল্যাটে ইলেকট্রিক ওয়্যারিং করতে হবে। ৩ বেডরুম, ১ লিভিং রুম, ১ কিচেন এবং ২ বাথরুম আছে। পুরো ফ্ল্যাটের জন্য নতুন ওয়্যারিং সিস্টেম তৈরি করতে হবে। বাসার মেইন electric line সমস্যা। পুরো ফ্ল্যাটে কারেন্ট নেই। জরুরিভাবে মেরামত প্রয়োজন।</p>
                        
                        <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                            <p class="font-medium text-dark mb-2">কাজের অন্তর্ভুক্ত:</p>
                            <ul class="list-disc pl-5 space-y-1">
                                <li>সব রুমে লাইট পয়েন্ট বসানো</li>
                                <li>পাওয়ার পয়েন্ট (সকেট) বসানো</li>
                                <li>ফ্যান/লাইট সুইচিং সিস্টেম</li>
                                <li>জরুরী লাইট এবং ব্যাকআপ সিস্টেম</li>
                                <li>কিচেনের জন্য আলাদা লাইন</li>
                            </ul>
                        </div>
                        
                        <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="font-medium text-yellow-800 mb-2">বিশেষ নির্দেশনা:</p>
                            <ul class="list-disc pl-5 space-y-1 text-yellow-700">
                                <li>স্থানীয় ইলেকট্রিক সাপ্লাই কোম্পানির রেগুলেশন অনুসরণ করতে হবে</li>
                                <li>সব কাজের ছবি তুলে রাখতে হবে</li>
                                <li>সামগ্রী সরবরাহ করা হবে না, শুধুমাত্র শ্রম</li>
                                <li>কাজ শেষ হবার পর ইলেকট্রিক বিল্ডিং কোড সার্টিফিকেট প্রয়োজন</li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Requirements -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-dark mb-3">প্রয়োজনীয়তা:</h3>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-2 bg-blue-100 text-blue-800 rounded-lg text-sm font-medium">
                                <i class="fas fa-certificate mr-2"></i>ইলেকট্রিশিয়ান সার্টিফিকেট
                            </span>
                            <span class="px-3 py-2 bg-green-100 text-green-800 rounded-lg text-sm font-medium">
                                <i class="fas fa-briefcase mr-2"></i>৩+ বছর অভিজ্ঞতা
                            </span>
                            <span class="px-3 py-2 bg-orange-100 text-orange-800 rounded-lg text-sm font-medium">
                                <i class="fas fa-tools mr-2"></i>নিজস্ব টুলস
                            </span>
                            <span class="px-3 py-2 bg-purple-100 text-purple-800 rounded-lg text-sm font-medium">
                                <i class="fas fa-car mr-2"></i>পরিবহন সুবিধা
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Timeline & Location -->
                <div class="bg-white rounded-lg shadow-md p-6 animate-fade-in">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Timeline -->
                        <div>
                            <h2 class="text-xl font-bold text-dark mb-4 flex items-center">
                                <i class="fas fa-calendar-alt text-primary mr-3"></i>
                                সময়সূচী
                            </h2>
                            
                            <div class="border-l-4 border-primary pl-6 ml-2">
                                <div class="mb-6 relative">
                                    <div class="absolute -left-9 w-6 h-6 bg-primary rounded-full border-4 border-white"></div>
                                    <div>
                                        <p class="font-semibold text-dark">টাস্ক পোস্ট করা</p>
                                        <p class="text-gray-600 text-sm">৩০ মিনিট আগে</p>
                                    </div>
                                </div>
                                <div class="mb-6 relative">
                                    <div class="absolute -left-9 w-6 h-6 bg-accent rounded-full border-4 border-white"></div>
                                    <div>
                                        <p class="font-semibold text-dark">বিড গ্রহণ</p>
                                        <p class="text-gray-600 text-sm">আজ সন্ধ্যা ৬টার মধ্যে</p>
                                    </div>
                                </div>
                                <div class="relative">
                                    <div class="absolute -left-9 w-6 h-6 bg-green-500 rounded-full border-4 border-white"></div>
                                    <div>
                                        <p class="font-semibold text-dark">কাজ শেষের তারিখ</p>
                                        <p class="text-gray-600 text-sm">আজ রাত ১০টার মধ্যে</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Location -->
                        <div>
                            <h2 class="text-xl font-bold text-dark mb-4 flex items-center">
                                <i class="fas fa-map-marker-alt text-primary mr-3"></i>
                                লোকেশন
                            </h2>
                            
                            <div class="h-48 bg-gray-200 rounded-lg mb-4 flex items-center justify-center">
                                <div class="text-center">
                                    <i class="fas fa-map text-gray-400 text-4xl mb-2"></i>
                                    <p class="text-gray-600">মিরপুর, ঢাকা</p>
                                </div>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex items-center text-gray-700">
                                    <i class="fas fa-road w-6 text-blue-600"></i>
                                    <span class="ml-3">মিরপুর সেকশন ১০</span>
                                </div>
                                <div class="flex items-center text-gray-700">
                                    <i class="fas fa-building w-6 text-green-600"></i>
                                    <span class="ml-3">৫ তলা আবাসিক ভবন</span>
                                </div>
                                <div class="flex items-center text-gray-700">
                                    <i class="fas fa-parking w-6 text-orange-600"></i>
                                    <span class="ml-3">পার্কিং সুবিধা আছে</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Photos -->
                <div class="bg-white rounded-lg shadow-md p-6 animate-fade-in">
                    <h2 class="text-xl font-bold text-dark mb-4 flex items-center">
                        <i class="fas fa-images text-primary mr-3"></i>
                        রেফারেন্স ছবি
                    </h2>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="relative h-40 bg-gray-200 rounded-lg overflow-hidden flex items-center justify-center">
                            <i class="fas fa-home text-gray-400 text-3xl"></i>
                        </div>
                        <div class="relative h-40 bg-gray-200 rounded-lg overflow-hidden flex items-center justify-center">
                            <i class="fas fa-plug text-gray-400 text-3xl"></i>
                        </div>
                        <div class="relative h-40 bg-gray-200 rounded-lg overflow-hidden flex items-center justify-center">
                            <i class="fas fa-bolt text-gray-400 text-3xl"></i>
                        </div>
                    </div>
                </div>
            </div>
</template>