<script setup>
import { Head } from '@inertiajs/vue3'
import CustomerDefaultLayout from '@/Layouts/CustomerDefaultLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import SelectInput from '@/Components/SelectInput.vue';
import Tips from './Partials/SideBar/Tips.vue';
import Pricing from './Partials/SideBar/Pricing.vue';
import Informations from './Partials/SideBar/Informations.vue';
import Services from './Partials/Services.vue';
import PageTitle from './Partials/PageTitle.vue';


const Options = [
  { value: 'normal', label: 'সাধারণ (২৪-৪৮ ঘন্টা)' },
  { value: 'urgent', label: 'জরুরি (১২-২৪ ঘন্টা)' },
  { value: 'emergency', label: 'ইমার্জেন্সি (৬-১২ ঘন্টা)' },
]

const districts = [
  { value: 'Dhaka', label: 'Dhaka' },
  { value: 'Chottogram', label: 'Chottogram' },
  { value: 'Khulna', label: 'Khulna' },
]
</script>



<template>
    <CustomerDefaultLayout>

        <Head title="গিগ তৈরি" />
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
                                <Services />
                                <div class="mb-8">
                                    <h3 class="text-xl font-bold text-dark mb-6">টাস্কের বিস্তারিত</h3>
                                    <div class="space-y-6">
                                        <div>
                                            <InputLabel for="টাস্কের শিরোনাম" value="টাস্কের শিরোনাম" required />
                                            <TextInput type="text"
                                                class="w-full p-3"
                                                placeholder="উদা: বাড়ির জন্য ইলেকট্রিক ওয়্যারিং" />

                                        </div>
                                        <div>
                                            <InputLabel for="বিস্তারিত বর্ণনা" value="বিস্তারিত বর্ণনা" required />
                                            <TextArea
                                                class="w-full  p-3"
                                                placeholder="আপনার কাজের সম্পূর্ণ বিস্তারিত বর্ণনা দিন..." />
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <InputLabel for="আনুমানিক বাজেট" value="আনুমানিক বাজেট (৳)" required />
                                                <TextInput type="number"
                                                    class="w-full p-3"
                                                    placeholder="উদা: বাড়ির জন্য ইলেকট্রিক ওয়্যারিং" />
                                            </div>
                                            <div>
                                                <InputLabel for="জরুরিতা" value="জরুরিতা"/>
                                                 <SelectInput class="w-full p-3"
                                                  defaultVal="জরুরিতা নির্বাচন করুন"
                                                  :options="Options"
                                                 />  
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Location Details -->
                                <div class="mb-8">
                                    <h3 class="text-xl font-bold text-dark mb-6">লোকেশন তথ্য</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                        <div>
                                                <InputLabel for="বিভাগ" value="বিভাগ"/>
                                                 <SelectInput class="w-full p-3"
                                                  defaultVal="বিভাগ নির্বাচন করুন"
                                                  :options="districts"
                                                 />  
                                        </div>
                                        <div>
                                                <InputLabel for="জেলা" value="জেলা"/>
                                                 <SelectInput class="w-full p-3"
                                                  defaultVal="জেলা নির্বাচন করুন"
                                                  :options="districts"
                                                 />  
                                        </div>
                                        <div>
                                                <InputLabel for="উপজীলা" value="উপজীলা"/>
                                                 <SelectInput class="w-full p-3"
                                                  defaultVal="উপজীলা নির্বাচন করুন"
                                                  :options="districts"
                                                 />  
                                        </div>
                                        <div class="md:col-span-2">
                                             <div>
                                            <InputLabel for="বিস্তারিত বর্ণনা" value="বিস্তারিত বর্ণনা" required />
                                            <TextArea
                                                class="w-full p-3"
                                                placeholder="আপনার কাজের সম্পূর্ণ বিস্তারিত বর্ণনা দিন..." />
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