<script setup>
import { Head } from '@inertiajs/vue3'
import CustomerDefaultLayout from '@/Layouts/CustomerDefaultLayout.vue';
import Tips from './Partials/SideBar/Tips.vue';
import Pricing from './Partials/SideBar/Pricing.vue';
import Informations from './Partials/SideBar/Informations.vue';
import Services from './Partials/Services.vue';
import PageTitle from './Partials/PageTitle.vue';
</script>



<template>
    <CustomerDefaultLayout>

        <Head title="গিগ তৈরি"/>
        <!-- Service Request Page -->
        <div class="min-h-screen py-8">
            <div class="max-w-6xl mx-auto px-4">
                <!-- Page Header -->
                <PageTitle />
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Main Form -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-md p-8">
                            <form id="serviceRequestForm">
                                <!-- Service Selection -->
                                <Services/>
                                <div class="mb-8">
                                    <h3 class="text-xl font-bold text-dark mb-6">টাস্কের বিস্তারিত</h3>
                                    <div class="space-y-6">
                                        <div>
                                            <label class="block text-dark font-medium mb-2">টাস্কের শিরোনাম <span
                                                    class="text-red-500">*</span></label>
                                            <input type="text"
                                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                                placeholder="উদা: বাড়ির জন্য ইলেকট্রিক ওয়্যারিং" >
                                        </div>
                                        <div>
                                            <label class="block text-dark font-medium mb-2">বিস্তারিত বর্ণনা <span
                                                    class="text-red-500">*</span></label>
                                            <textarea
                                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                                rows="4" placeholder="আপনার কাজের সম্পূর্ণ বিস্তারিত বর্ণনা দিন..."
                                                required></textarea>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-dark font-medium mb-2">আনুমানিক বাজেট
                                                    (৳)</label>
                                                <input type="number"
                                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                                    placeholder="500" min="100">
                                            </div>
                                            <div>
                                                <label class="block text-dark font-medium mb-2">জরুরিতা</label>
                                                <select
                                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                                    <option value="normal">সাধারণ (২৪-৪৮ ঘন্টা)</option>
                                                    <option value="urgent">জরুরি (১২-২৪ ঘন্টা)</option>
                                                    <option value="emergency">ইমার্জেন্সি (৬-১২ ঘন্টা)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Location Details -->
                                <div class="mb-8">
                                    <h3 class="text-xl font-bold text-dark mb-6">লোকেশন তথ্য</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-dark font-medium mb-2">বিভাগ <span
                                                    class="text-red-500">*</span></label>
                                            <select
                                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                                required>
                                                <option value="">বিভাগ নির্বাচন করুন</option>
                                                <option value="dhaka">ঢাকা</option>
                                                <option value="chattogram">চট্টগ্রাম</option>
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
                                        <div class="md:col-span-2">
                                            <label class="block text-dark font-medium mb-2">সম্পূর্ণ ঠিকানা <span
                                                    class="text-red-500">*</span></label>
                                            <textarea
                                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                                rows="2" placeholder="বাড়ি নম্বর, রোড নম্বর, এলাকা"
                                                required></textarea>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-dark font-medium mb-2">লোকেশন ম্যাপ</label>
                                            <div
                                                class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center bg-gray-50">
                                                <i class="fas fa-map-marker-alt text-3xl text-gray-400 mb-4"></i>
                                                <p class="text-gray-600 mb-2">আপনার লোকেশন সেট করুন</p>
                                                <button type="button"
                                                    class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                                    <i class="fas fa-location-arrow mr-2"></i> লোকেশন সেট করুন
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Information -->
                                <div class="mb-8">
                                    <h3 class="text-xl font-bold text-dark mb-6">যোগাযোগ তথ্য</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-dark font-medium mb-2">আপনার নাম <span
                                                    class="text-red-500">*</span></label>
                                            <input type="text"
                                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                                required>
                                        </div>
                                        <div>
                                            <label class="block text-dark font-medium mb-2">মোবাইল নম্বর <span
                                                    class="text-red-500">*</span></label>
                                            <input type="tel"
                                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit"
                                    class="w-full bg-primary text-white py-4 rounded-lg hover:bg-blue-700 font-medium text-lg">
                                    টাস্ক পোস্ট করুন
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Sidebar - Information & Tips -->
                    <div class="space-y-6">
                        <Informations />
                        <Pricing />
                        <Tips />
                    </div>



                </div>
            </div>
        </div>
    </CustomerDefaultLayout>
</template>