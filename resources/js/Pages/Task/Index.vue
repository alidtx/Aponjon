<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Head } from '@inertiajs/vue3';
import PageHeadline from '@/Components/PageHeadline.vue';
import ProgressBar from './Partials/ProgressBar.vue';
import Benefits from './Partials/Benefits.vue';

</script>



<template>
    <DefaultLayout>

        <Head title="টাস্কার" />
        <div class="max-w-4xl mx-auto px-4">
            <PageHeadline title="টাস্কার হিসেবে" highlight="রেজিস্টার করুন"
                description="আপনার দক্ষতা ব্যবহার করে আয় করুন এবং মানুষকে সাহায্য করুন।" />
            <!-- Progress Steps -->
            <ProgressBar />

            <!-- Registration Form -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <form id="taskerRegistrationForm">
                    <!-- Personal Information -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-dark mb-6">ব্যক্তিগত তথ্য</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-dark font-medium mb-2">পূর্ণ নাম <span
                                        class="text-red-500">*</span></label>
                                <input type="text"
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="আপনার পূর্ণ নাম লিখুন" required>
                            </div>
                            <div>
                                <label class="block text-dark font-medium mb-2">মোবাইল নম্বর <span
                                        class="text-red-500">*</span></label>
                                <input type="tel"
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="01XXXXXXXXX" required>
                            </div>
                            <div>
                                <label class="block text-dark font-medium mb-2">ইমেইল</label>
                                <input type="email"
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="your@email.com">
                            </div>
                            <div>
                                <label class="block text-dark font-medium mb-2">এনআইডি নম্বর <span
                                        class="text-red-500">*</span></label>
                                <input type="text"
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="জাতীয় পরিচয়পত্র নম্বর" required>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-dark mb-6">ঠিকানা তথ্য</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-dark font-medium mb-2">বিভাগ <span
                                        class="text-red-500">*</span></label>
                                <select
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                    required>
                                    <option value="">বিভাগ নির্বাচন করুন</option>
                                    <option value="dhaka">ঢাকা</option>
                                    <option value="chattogram">চট্টগ্রাম</option>
                                    <option value="khulna">খুলনা</option>
                                    <option value="rajshahi">রাজশাহী</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-dark font-medium mb-2">জেলা <span
                                        class="text-red-500">*</span></label>
                                <select
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                    required>
                                    <option value="">জেলা নির্বাচন করুন</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-dark font-medium mb-2">উপজেলা/থানা <span
                                        class="text-red-500">*</span></label>
                                <select
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                    required>
                                    <option value="">উপজেলা নির্বাচন করুন</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-dark font-medium mb-2">পূর্ণ ঠিকানা <span
                                        class="text-red-500">*</span></label>
                                <textarea
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                    rows="3" placeholder="বাড়ি নম্বর, রাস্তা, এলাকা" required></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Skills and Services -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-dark mb-6">আপনার দক্ষতা ও সেবা</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div
                                class="flex items-center p-4 border border-gray-300 rounded-lg hover:border-primary cursor-pointer">
                                <input type="checkbox" class="w-5 h-5 text-primary rounded">
                                <div class="ml-3">
                                    <span class="font-medium text-dark">ইলেকট্রিক কাজ</span>
                                    <p class="text-sm text-gray-600">ওয়্যারিং, সুইচ, ফ্যান ইন্সটলেশন</p>
                                </div>
                            </div>
                            <div
                                class="flex items-center p-4 border border-gray-300 rounded-lg hover:border-primary cursor-pointer">
                                <input type="checkbox" class="w-5 h-5 text-primary rounded">
                                <div class="ml-3">
                                    <span class="font-medium text-dark">প্লাম্বিং কাজ</span>
                                    <p class="text-sm text-gray-600">পাইপ লাইন, ট্যাপ, স্যানিটারি</p>
                                </div>
                            </div>
                            <div
                                class="flex items-center p-4 border border-gray-300 rounded-lg hover:border-primary cursor-pointer">
                                <input type="checkbox" class="w-5 h-5 text-primary rounded">
                                <div class="ml-3">
                                    <span class="font-medium text-dark">ক্লিনিং সার্ভিস</span>
                                    <p class="text-sm text-gray-600">বাড়ি, অফিস, কার্পেট ক্লিনিং</p>
                                </div>
                            </div>
                            <div
                                class="flex items-center p-4 border border-gray-300 rounded-lg hover:border-primary cursor-pointer">
                                <input type="checkbox" class="w-5 h-5 text-primary rounded">
                                <div class="ml-3">
                                    <span class="font-medium text-dark">ফার্নিচার অ্যাসেম্বলি</span>
                                    <p class="text-sm text-gray-600">আইকিয়া, লোকাল ফার্নিচার</p>
                                </div>
                            </div>
                        </div>

                        <!-- Hourly Rate -->
                        <div class="mb-6">
                            <label class="block text-dark font-medium mb-2">আপনার ঘণ্টাপ্রতি রেট (৳)</label>
                            <div class="flex items-center">
                                <input type="range" min="100" max="1000" step="50" class="flex-1" value="300">
                                <span class="ml-4 text-lg font-bold text-primary">৳<span
                                        id="rateValue">300</span></span>
                            </div>
                        </div>

                        <!-- Experience -->
                        <div>
                            <label class="block text-dark font-medium mb-2">অভিজ্ঞতা (বছর)</label>
                            <select
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="0">কোন অভিজ্ঞতা নেই</option>
                                <option value="1">১ বছর</option>
                                <option value="2">২ বছর</option>
                                <option value="3">৩ বছর</option>
                                <option value="5">৫ বছর+</option>
                            </select>
                        </div>
                    </div>

                    <!-- Documents Upload -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-dark mb-6">ডকুমেন্ট আপলোড</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-dark font-medium mb-2">এনআইডি ফ্রন্ট সাইড <span
                                        class="text-red-500">*</span></label>
                                <div
                                    class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary cursor-pointer">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                    <p class="text-gray-600">ফাইল নির্বাচন করুন বা ড্র্যাগ করুন</p>
                                    <p class="text-sm text-gray-500">JPG, PNG (সর্বোচ্চ ৫MB)</p>
                                </div>
                            </div>
                            <div>
                                <label class="block text-dark font-medium mb-2">এনআইডি ব্যাক সাইড <span
                                        class="text-red-500">*</span></label>
                                <div
                                    class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary cursor-pointer">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                    <p class="text-gray-600">ফাইল নির্বাচন করুন বা ড্র্যাগ করুন</p>
                                    <p class="text-sm text-gray-500">JPG, PNG (সর্বোচ্চ ৫MB)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Terms and Submit -->
                    <div class="mb-6">
                        <div class="flex items-start">
                            <input type="checkbox" class="w-5 h-5 text-primary rounded mt-1" required>
                            <label class="ml-3 text-gray-700">
                                আমি <a href="#" class="text-primary hover:underline">টার্মস অ্যান্ড কন্ডিশন</a> এবং <a
                                    href="#" class="text-primary hover:underline">প্রাইভেসি পলিসি</a> পড়েছি এবং সম্মতি
                                দিচ্ছি
                            </label>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-primary text-white py-4 rounded-lg hover:bg-blue-700 font-medium text-lg">
                        রেজিস্টার সম্পন্ন করুন
                    </button>
                </form>
            </div>
            <!-- Benefits Section -->
            <Benefits />
        </div>
    </DefaultLayout>
</template>