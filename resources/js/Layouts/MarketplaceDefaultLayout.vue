<script setup>
import Navbar from '@/Layouts/Marketplace/NavBar/NavBar.vue'; 
</script>

<template>
    <Navbar />
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-dark mb-4">সেবার <span class="text-primary">অনুরোধসমূহ</span></h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                বাংলাদেশের বিভিন্ন প্রান্ত থেকে আসা হাজারো সেবার অনুরোধ। আপনার দক্ষতা অনুযায়ী কাজ খুঁজে নিন।
            </p>
        </div>
        <!-- Stats Bar -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                <div>
                    <div class="text-2xl font-bold text-primary">১,২৫৪</div>
                    <div class="text-sm text-gray-600">সক্রিয় টাস্ক</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-green-600">৳৮.৫লাখ+</div>
                    <div class="text-sm text-gray-600">মোট বাজেট</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-blue-600">৫৬৩</div>
                    <div class="text-sm text-gray-600">সক্রিয় টাস্কার</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-orange-600">৯৪%</div>
                    <div class="text-sm text-gray-600">সফলতার হার</div>
                </div>
            </div>
        </div>
        <div class="flex  lg:flex-row gap-8">
            <div class="lg:w-1/4">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h3 class="text-lg font-bold text-dark mb-4">ফিল্টার করুন</h3>

                    <!-- Category Filter -->
                    <div class="mb-6">
                        <label class="block font-medium text-dark mb-3">সেবা ক্যাটাগরি</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded text-primary" checked>
                                <span class="ml-2 text-gray-700">সকল ক্যাটাগরি</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded text-primary">
                                <span class="ml-2 text-gray-700">ইলেকট্রিক কাজ</span>
                                <span class="ml-auto text-gray-500">(১২৪)</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded text-primary">
                                <span class="ml-2 text-gray-700">প্লাম্বিং কাজ</span>
                                <span class="ml-auto text-gray-500">(৮৯)</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded text-primary">
                                <span class="ml-2 text-gray-700">ক্লিনিং সার্ভিস</span>
                                <span class="ml-auto text-gray-500">(১৫৬)</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded text-primary">
                                <span class="ml-2 text-gray-700">অ্যাসেম্বলি সার্ভিস</span>
                                <span class="ml-auto text-gray-500">(৬৭)</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded text-primary">
                                <span class="ml-2 text-gray-700">এর্যান্ড সার্ভিস</span>
                                <span class="ml-auto text-gray-500">(২০৩)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Location Filter -->
                    <div class="mb-6">
                        <label class="block font-medium text-dark mb-3">লোকেশন</label>
                        <select class="w-full p-2 border border-gray-300 rounded-lg">
                            <option value="">সকল এলাকা</option>
                            <option value="dhaka">ঢাকা</option>
                            <option value="chattogram">চট্টগ্রাম</option>
                            <option value="khulna">খুলনা</option>
                            <option value="rajshahi">রাজশাহী</option>
                        </select>
                    </div>

                    <!-- Budget Filter -->
                    <div class="mb-6">
                        <label class="block font-medium text-dark mb-3">বাজেট রেঞ্জ</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="budget" class="text-primary" checked>
                                <span class="ml-2 text-gray-700">সকল বাজেট</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="budget" class="text-primary">
                                <span class="ml-2 text-gray-700">৳৫০০ এর নিচে</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="budget" class="text-primary">
                                <span class="ml-2 text-gray-700">৳৫০০ - ৳১,০০০</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="budget" class="text-primary">
                                <span class="ml-2 text-gray-700">৳১,০০০ - ৳২,০০০</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="budget" class="text-primary">
                                <span class="ml-2 text-gray-700">৳২,০০০+</span>
                            </label>
                        </div>
                    </div>

                    <!-- Urgency Filter -->
                    <div class="mb-6">
                        <label class="block font-medium text-dark mb-3">জরুরিতা</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded text-primary" checked>
                                <span class="ml-2 text-gray-700">সকল</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded text-primary">
                                <span class="ml-2 text-red-600">
                                    <i class="fas fa-bolt mr-1"></i>ইমার্জেন্সি
                                </span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded text-primary">
                                <span class="ml-2 text-orange-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>জরুরি
                                </span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded text-primary">
                                <span class="ml-2 text-green-600">সাধারণ</span>
                            </label>
                        </div>
                    </div>

                    <button class="w-full bg-primary text-white py-2 rounded-lg hover:bg-blue-700 font-medium">
                        ফিল্টার প্রয়োগ করুন
                    </button>
                </div>
            </div>
            <slot />
        </div>
    </div>
</template>