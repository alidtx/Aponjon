<script setup>
import Accordion from '@/Components/Accordion.vue'

const props = defineProps({
    details: {
        type: Object,
        required: true
    },
})

const timeAgo = (dateTime) => {
    if (!dateTime) return ''

    const now = new Date()
    const past = new Date(dateTime.replace(' ', 'T'))
    const diffSeconds = Math.floor((now - past) / 1000)

    if (diffSeconds < 60) {
        return `${diffSeconds} সেকেন্ড আগে`
    }

    const diffMinutes = Math.floor(diffSeconds / 60)
    if (diffMinutes < 60) {
        return `${diffMinutes} মিনিট আগে`
    }

    const diffHours = Math.floor(diffMinutes / 60)
    if (diffHours < 24) {
        return `${diffHours} ঘন্ট আগে`
    }

    const diffDays = Math.floor(diffHours / 24)
    return `${diffDays} দিন আগে`
}

const URGENCY_MAP = {
    normal: {
        text: 'সাধারণ',
        icon: 'fa-circle',
        border: 'border-green-600',
        textColor: 'text-green-600',
        bgColor: 'bg-green-100',
        notice: 'গ্রাহক কাজটি নির্ধারিত সময়ের মধ্যে সম্পন্ন করতে চান। স্বাভাবিক অগ্রাধিকার অনুযায়ী কাজটি করুন।'
    },
    urgent: {
        text: 'জরুরি',
        icon: 'fa-exclamation-circle',
        border: 'border-yellow-500',
        textColor: 'text-yellow-600',
        bgColor: 'bg-yellow-100',
        notice: 'গ্রাহক দ্রুত কাজটি সম্পন্ন করতে চান। উচ্চ অগ্রাধিকার দিয়ে যত দ্রুত সম্ভব কাজ শুরু করুন।'
    },
    emergency: {
        text: 'ইমার্জেন্সি',
        icon: 'fa-bolt',
        border: 'border-red-600',
        textColor: 'text-red-600',
        bgColor: 'bg-red-100',
        notice: 'এটি একটি জরুরি পরিস্থিতি। গ্রাহক অবিলম্বে সমাধান চান। অন্য কাজের আগে এটি অগ্রাধিকার দিন।'
    },
    other: {
        text: 'অন্যান্য',
        icon: 'fa-info-circle',
        border: 'border-blue-500',
        textColor: 'text-blue-600',
        bgColor: 'bg-blue-100',
        notice: 'এই কাজটি বিশেষ বা ভিন্ন ক্যাটাগরির অন্তর্ভুক্ত। প্রয়োজন অনুযায়ী পর্যালোচনা করে ব্যবস্থা নিন।'
    },
}
const urgency = (value = '') => URGENCY_MAP[value.toLowerCase()] || URGENCY_MAP.normal
const getLocation = (location) => {
    return [
        location.district?.name,
        location.zila?.name,
        location.upozila?.name
    ].filter(Boolean).join(', ')
}



</script>


<template>
    <div class="lg:col-span-2 space-y-6">
        <div 
        :class="[
                    'bg-white rounded-lg shadow-md border-l-4 hover:shadow-lg transition-shadow duration-300',
                    urgency(props.details.data.emergency).border
                ]"
        
        >
            <div class="p-6">
                <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                    <div class="flex items-center space-x-3">
                        <span class=""
                        :class="['status-emergency px-4 py-1.5 rounded-full text-sm font-medium',urgency(props.details.data.emergency).textColor]"
                        >
                             <i class="fas mr-1" :class="urgency(props.details.data.emergency).icon"></i>{{ urgency(props.details.data.emergency).text }}
                        </span>
                        <span class="category-electrical px-4 py-1.5 rounded-full text-sm font-medium">
                            <i class="fas fa-bolt mr-2"></i>{{ props.details.data.category.name }}
                        </span>
                    </div>

                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                        <span class="flex items-center">
                            <i class="far fa-eye mr-1"></i>
                            ২৪৫ বার দেখা
                        </span>
                        <span class="flex items-center">
                            <i class="far fa-clock mr-1"></i>
                            {{ timeAgo(props.details.data?.created_at) }}
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-gavel mr-1"></i>
                             {{ props.details.data?.bid?.length }} টি বিড
                        </span>
                    </div>
                </div>

                <h1 class="text-3xl font-bold text-dark mb-4">{{ props.details.data.title }}</h1>

                <div class="flex items-center text-gray-700 mb-6">
                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-user-circle text-gray-500 text-2xl"></i>
                    </div>
                    <div>
                        <p class="font-medium text-dark">{{ props.details.data.customer.name }}</p>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            <span>{{ getLocation(props.details.data) }}</span>
                            <i class="fas fa-star text-yellow-400 ml-4 mr-1"></i>
                            <span>৪.৮ (১২৩ রিভিউ)</span>
                        </div>
                    </div>
                </div>
                <div 
                 :class="[
                    'border rounded-lg p-4 mb-6',
                    urgency(props.details.data.emergency).bgColor, urgency(props.details.data.emergency).border
                ]"
                
                >
                    <div class="flex items-center">
                        <i class="fas mr-2" :class="urgency(props.details.data.emergency).icon"></i>
                        <div>
                            <p :class="['font-medium',urgency(props.details.data.emergency).textColor]">{{ urgency(props.details.data.emergency).text }}</p>
                            <p class="text-red-700 text-sm">{{ urgency(props.details.data.emergency).notice }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 animate-fade-in">
            <h2 class="text-xl font-bold text-dark mb-4 flex items-center">
                <i class="fas fa-align-left text-primary mr-3"></i>
                টাস্ক বিবরণ
            </h2>

            <div class="prose max-w-none text-gray-700 mb-6">
                 {{ props.details.data?.description }}
                <Accordion/>
            </div>
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