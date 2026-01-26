<script setup></script>

<template>
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-gem text-blue-500 mr-2"></i>বিড জেতার টিপস
                </h3>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-check text-green-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">বাজেটের কাছাকাছি বিড দিন</p>
                            <p class="text-sm text-gray-600">গ্রাহকের বাজেটের ১০-১৫% এর মধ্যে বিড দিন</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-check text-green-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">বিস্তারিত প্রস্তাবনা লিখুন</p>
                            <p class="text-sm text-gray-600">বিস্তারিত প্রস্তাবনা গ্রহণযোগ্যতা ৭০% বাড়ায়</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-check text-green-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">দ্রুত সময়সূচী দিন</p>
                            <p class="text-sm text-gray-600">যত দ্রুত শুরু করবেন, নির্বাচিত হওয়ার সম্ভাবনা তত বেশি</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-check text-green-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">প্রোফাইল সম্পূর্ণ রাখুন</p>
                            <p class="text-sm text-gray-600">সম্পূর্ণ প্রোফাইল বিড গ্রহণযোগ্যতা ৪০% বাড়ায়</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bid Statistics -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6">এই টাস্কের বিড স্ট্যাটাস</h3>
                
                <div class="space-y-5">
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">মোট বিড</span>
                            <span class="font-bold text-blue-600">১২ টি</span>
                        </div>
                        <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-500" style="width: 100%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">গড় বিড মূল্য</span>
                            <span class="font-bold text-green-600">৳৩,২০০</span>
                        </div>
                        <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-green-500" style="width: 80%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">সর্বনিম্ন বিড</span>
                            <span class="font-bold text-red-600">৳১,৮০০</span>
                        </div>
                        <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-red-500" style="width: 45%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">সর্বোচ্চ বিড</span>
                            <span class="font-bold text-purple-600">৳৪,৫০০</span>
                        </div>
                        <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-purple-500" style="width: 90%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-yellow-800 text-sm">
                        <span class="font-bold">দ্রষ্টব্য:</span> আপনার বিড জমা দেওয়ার পর ২৪ ঘন্টার জন্য বাইন্ডিং থাকবে। বিড জমা দেওয়ার পরে তা বাতিল করা যাবে না।
                    </p>
                </div>
            </div>

            <!-- Important Notes -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>গুরুত্বপূর্ণ নোট
                </h3>
                
                <div class="space-y-3">
                    <div class="flex items-start">
                        <i class="fas fa-circle text-xs text-red-500 mt-2 mr-3"></i>
                        <p class="text-gray-700 text-sm">বিড একবার জমা দিলে তা পরিবর্তন বা বাতিল করা যাবে না</p>
                    </div>
                    
                    <div class="flex items-start">
                        <i class="fas fa-circle text-xs text-red-500 mt-2 mr-3"></i>
                        <p class="text-gray-700 text-sm">গ্রাহক নির্বাচন করলে আপনি কাজটি করতে বাধ্য থাকবেন</p>
                    </div>
                    
                    <div class="flex items-start">
                        <i class="fas fa-circle text-xs text-red-500 mt-2 mr-3"></i>
                        <p class="text-gray-700 text-sm">বিড জমা দেওয়ার পর ২৪ ঘন্টার জন্য বাইন্ডিং থাকবে</p>
                    </div>
                    
                    <div class="flex items-start">
                        <i class="fas fa-circle text-xs text-red-500 mt-2 mr-3"></i>
                        <p class="text-gray-700 text-sm">অনুপযুক্ত বিডের জন্য আপনার অ্যাকাউন্ট সাসপেন্ড হতে পারে</p>
                    </div>
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex items-center justify-center text-gray-600">
                        <i class="fas fa-headset text-xl mr-3 text-blue-500"></i>
                        <div>
                            <p class="font-medium">সাহায্য প্রয়োজন?</p>
                            <p class="text-sm">কল করুন: ১৬৩৪৫</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>