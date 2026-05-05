<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Head } from '@inertiajs/vue3';
import ProfileHead from './Partials/ProfileHead.vue';
import SideBar from './Partials/SideBar.vue';
import { computed } from 'vue';

const props = defineProps({
    profile: {
        type: Object,
        default: () => ({})
    }
})

const name = computed(() => props.profile.data?.name)
const profile_id = computed(() => props.profile.data?.id)
const designation = computed(() => props.profile.data?.tasker_profile?.designation)
const address = computed(() => props.profile.data?.tasker_profile?.full_address)
const photo = computed(() => props.profile.data?.tasker_profile?.profile_photo)
const skills = computed(() => props.profile.data?.tasker_profile?.skills)

</script>


<template>
    <DefaultLayout>

        <Head title="পাবলিক প্রফাইল" />
        <ProfileHead :name="name" :designation="designation" :address="address" :photo="photo" />
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-dark mb-4">আমার সম্পর্কে</h2>
                    <p class="text-gray-700 leading-relaxed">{{ props.profile.data?.tasker_profile.bio }}</p>

                    <div class="mt-6">
                        <h3 class="font-bold text-dark mb-3">বিশেষজ্ঞতা</h3>

                        <div class="flex flex-wrap gap-2">
                            <span v-for="(item, index) in skills" :key="index"

                                class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-sm">
                                {{ item }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-dark mb-4">সেবাসমূহ ও মূল্য</h2>
                    <div class="space-y-4">

                        <div class="flex justify-between items-center p-4 border border-gray-200 rounded-lg">
                            <div>
                                <h3 class="font-bold text-dark">বেসিক ইলেকট্রিক মেরামত</h3>
                                <p class="text-sm text-gray-600">সুইচ, সকেট, ফিউজ বক্স মেরামত</p>
                            </div>
                            <div class="text-right">
                                <div class="font-bold text-primary">৳৩০০ - ৳৮০০</div>
                                <div class="text-sm text-gray-600">শুরু হয়</div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center p-4 border border-gray-200 rounded-lg">
                            <div>
                                <h3 class="font-bold text-dark">হোম ওয়্যারিং</h3>
                                <p class="text-sm text-gray-600">নতুন বাসার সম্পূর্ণ ইলেকট্রিক ওয়্যারিং</p>
                            </div>
                            <div class="text-right">
                                <div class="font-bold text-primary">৳২,০০০ - ৳১০,০০০</div>
                                <div class="text-sm text-gray-600">বাসার সাইজ অনুযায়ী</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-dark">গ্রাহক রিভিউ</h2>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-dark">৪.৫<small class="text-lg text-gray-600">/৫</small>
                            </div>
                            <div class="text-sm text-gray-600">৪৫টি রিভিউ</div>
                        </div>
                    </div>
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h4 class="font-bold text-dark">রহিমা আক্তার</h4>
                                <div class="flex items-center space-x-2 text-sm text-gray-600">
                                    <span>ধানমন্ডি, ঢাকা</span>
                                    <span>•</span>
                                    <span>২ সপ্তাহ আগে</span>
                                </div>
                            </div>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <p class="text-gray-700">
                            করিমুল ভাই খুবই এক্সপার্ট ইলেকট্রিশিয়ান। আমাদের বাসার পুরাতন ওয়্যারিং সম্পূর্ণ চেঞ্জ
                            করেছেন।
                            খুব ক্লিন ও নিয়ম মেনে কাজ করেছেন। দামও যৌক্তিক।强烈推荐!
                        </p>
                        <div class="flex space-x-2 mt-3">
                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">ইলেকট্রিক ওয়্যারিং</span>
                        </div>
                    </div>

                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h4 class="font-bold text-dark">আহমেদ হাসান</h4>
                                <div class="flex items-center space-x-2 text-sm text-gray-600">
                                    <span>গুলশান, ঢাকা</span>
                                    <span>•</span>
                                    <span>১ মাস আগে</span>
                                </div>
                            </div>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                        <p class="text-gray-700">
                            অফিসের ইমার্জেন্সি ইলেকট্রিক সমস্যা নিয়ে ডাকেছিলাম। ১ ঘন্টার মধ্যে এসে সমস্যা সল্ভ করেছেন।
                            প্রফেশনাল এবং সময়নিষ্ঠ।
                        </p>
                        <div class="flex space-x-2 mt-3">
                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">ইমার্জেন্সি সার্ভিস</span>
                        </div>
                    </div>

                    <button class="w-full py-3 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium">
                        আরও রিভিউ দেখুন
                    </button>
                </div>
            </div>
            <SideBar 
              :profileId="profile_id" 
            />
        </div>
    </DefaultLayout>
</template>