<script setup>
import Accordion from '@/Components/Accordion.vue';
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useTimeLeft } from '@/composables/useTimeLeft'
import { useTimeAgo } from '@/composables/useTimeAgo'

const page = usePage()

const props=defineProps({
   bidDetails:{
    type:Object,
    required:true
   }
})
const deadline = ref(props.bidDetails.data?.bidding_ends_at)
const createdAt  = ref(props.bidDetails.data?.created_at)

const bidAvices = page.props.bid_advices
const timeLeft = useTimeLeft(deadline)
const timeAgo = useTimeAgo(createdAt)

</script>

<template>
 <div class="lg:col-span-2 animate-fade-in">
            <!-- Bid Form Container -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <!-- Form Header -->
                <div class="bg-primary text-white p-6 md:p-8 rounded-lg shadow-md">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-2xl md:text-3xl font-bold text-white mb-3">বিড সাবমিট করুন</h2>
                            <div class="flex flex-wrap items-center gap-2 mb-4">
                                <span class="text-blue-100 bg-blue-800 bg-opacity-30 px-3 py-1 rounded-full text-sm font-medium">
                                    <i class="fas fa-bolt mr-1"></i> কাজের নংঃ {{ props.bidDetails.data.task_number }}
                                </span>
                                <span class="text-blue-100 bg-blue-800 bg-opacity-30 px-3 py-1 rounded-full text-sm font-medium">
                                    <i class="fas fa-calendar mr-1"></i> {{ timeLeft }}
                                </span>
                            </div>
                        </div>
                        <div class="text-right hidden md:block">
                            <div class="text-blue-200 text-sm">টাস্ক পোস্ট হয়েছে</div>
                            <div class="text-white font-bold">{{ timeAgo }}</div>
                        </div>
                    </div>
                    
                    <!-- Task Description Card -->
                    <div class="mt-6 bg-blue-800 bg-opacity-30 rounded-lg p-4">
                        <h3 class="text-white font-bold text-lg mb-3">বাসার ইলেকট্রিক ওয়্যারিং</h3>
                        <p class="text-blue-100 mb-4">বাসার জন্য সম্পূর্ণ ইলেকট্রিক ওয়্যারিং সেটআপ করতে হবে। ৩ বেডরুম, ১ ড্রইং রুম, ১ কিচেন এবং ২ বাথরুম। পুরাতন ওয়্যারিং রিপ্লেসমেন্ট এবং নতুন পয়েন্ট ইন্সটলেশন প্রয়োজন।</p>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <p class="text-blue-200 text-sm">গ্রাহকের বাজেট</p>
                                <p class="text-white font-bold text-lg">৳২,০০০ - ৳৪,০০০</p>
                            </div>
                            <div>
                                <p class="text-blue-200 text-sm">গড় মূল্য</p>
                                <p class="text-white font-bold text-lg">৳৩,০০০</p>
                            </div>
                            <div>
                                <p class="text-blue-200 text-sm">লোকেশন</p>
                                <p class="text-white font-bold text-lg">ধানমন্ডি, ঢাকা</p>
                            </div>
                            <div>
                                <p class="text-blue-200 text-sm">বিডস</p>
                                <p class="text-white font-bold text-lg">১২ টি</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bid Form -->
                <form class="p-6 md:p-8">
                    <!-- Bid Amount Section -->
                    <div class="mb-10">
                        <div class="flex items-start mb-6">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-money-bill-wave text-blue-600 text-xl"></i>
                            </div>
                            <div class="flex-grow">
                                <label class="block text-gray-800 font-semibold text-xl mb-2">
                                    আপনার প্রস্তাবিত মূল্য <span class="text-red-500">*</span>
                                </label>
                                <p class="text-gray-600">গ্রাহকের বাজেটের সাথে মিলিয়ে প্রস্তাব দিন। কম মূল্যে ভালো সার্ভিস দিতে পারলে বিড জেতার সম্ভাবনা বাড়ে।</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label class="block text-gray-700 font-medium mb-3">আপনার বিড (৳)</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-4 text-gray-600 text-2xl">৳</span>
                                    <input type="number" 
                                           class="w-full pl-12 pr-4 py-4 border-2 border-gray-300 rounded-xl focus:border-blue-500 text-xl font-bold transition-colors" 
                                           placeholder="1500" value="2500">
                                </div>
                                <p class="text-sm text-gray-500 mt-2">একবার বিড জমা দিলে তা পরিবর্তন করা যাবে না</p>
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 font-medium mb-3">সার্ভিস চার্জ (১০%)</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-4 text-gray-600 text-2xl">৳</span>
                                    <input type="text" 
                                           class="w-full pl-12 pr-4 py-4 border-2 border-gray-300 rounded-xl bg-gray-50 text-xl font-bold" 
                                           value="250" readonly>
                                </div>
                                <p class="text-sm text-gray-500 mt-2">এই চার্জ প্ল্যাটফর্ম ফি হিসেবে নেয়া হয়</p>
                            </div>
                        </div>
                        
                        <!-- Budget Indicator -->
                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-gray-800 font-semibold text-lg">বাজেট তুলনা</span>
                                <div class="text-right">
                                    <span class="font-bold text-green-600 text-lg">৳৫০০ কম</span>
                                    <p class="text-sm text-gray-600">গ্রাহকের সর্বনিম্ন বাজেট থেকে</p>
                                </div>
                            </div>
                            <div class="h-4 bg-gray-200 rounded-full overflow-hidden relative mb-3">
                                <div class="h-full bg-gradient-to-r from-green-500 via-yellow-500 to-red-500 w-full"></div>
                                <div class="h-8 w-8 bg-blue-700 rounded-full border-4 border-white shadow-lg absolute -top-2" style="left: 45%;"></div>
                            </div>
                            <div class="flex justify-between text-gray-700 font-medium">
                                <div class="text-center">
                                    <div class="font-bold">৳২,০০০</div>
                                    <div class="text-sm text-gray-600">সর্বনিম্ন</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-bold">৳৩,০০০</div>
                                    <div class="text-sm text-gray-600">গড়</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-bold">৳৪,০০০</div>
                                    <div class="text-sm text-gray-600">সর্বোচ্চ</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Time and Availability Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                        <!-- Estimated Time -->
                        <div>
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-clock text-blue-600 text-lg"></i>
                                </div>
                                <div>
                                    <label class="block text-gray-800 font-semibold text-lg">
                                        আনুমানিক সময় <span class="text-red-500">*</span>
                                    </label>
                                    <p class="text-gray-600 text-sm">কাজ শেষ করতে কত সময় লাগবে?</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-3 gap-3">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="estimated_hours" value="1" class="hidden peer" checked>
                                    <div class="h-full p-4 border-2 border-gray-300 rounded-xl text-center transition-all hover:border-blue-400 peer-checked:border-blue-600 peer-checked:bg-blue-50">
                                        <div class="text-2xl font-bold text-gray-800">১</div>
                                        <div class="text-gray-600">ঘন্টা</div>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="estimated_hours" value="2" class="hidden peer">
                                    <div class="h-full p-4 border-2 border-gray-300 rounded-xl text-center transition-all hover:border-blue-400 peer-checked:border-blue-600 peer-checked:bg-blue-50">
                                        <div class="text-2xl font-bold text-gray-800">২</div>
                                        <div class="text-gray-600">ঘন্টা</div>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="estimated_hours" value="3" class="hidden peer">
                                    <div class="h-full p-4 border-2 border-gray-300 rounded-xl text-center transition-all hover:border-blue-400 peer-checked:border-blue-600 peer-checked:bg-blue-50">
                                        <div class="text-2xl font-bold text-gray-800">৩</div>
                                        <div class="text-gray-600">ঘন্টা</div>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="estimated_hours" value="4" class="hidden peer">
                                    <div class="h-full p-4 border-2 border-gray-300 rounded-xl text-center transition-all hover:border-blue-400 peer-checked:border-blue-600 peer-checked:bg-blue-50">
                                        <div class="text-2xl font-bold text-gray-800">৪</div>
                                        <div class="text-gray-600">ঘন্টা</div>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer col-span-2">
                                    <input type="radio" name="estimated_hours" value="5" class="hidden peer">
                                    <div class="h-full p-4 border-2 border-gray-300 rounded-xl text-center transition-all hover:border-blue-400 peer-checked:border-blue-600 peer-checked:bg-blue-50">
                                        <div class="text-xl font-bold text-gray-800">৫+ ঘন্টা</div>
                                        <div class="text-gray-600">দীর্ঘমেয়াদী</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Availability -->
                        <div>
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-calendar-alt text-blue-600 text-lg"></i>
                                </div>
                                <div>
                                    <label class="block text-gray-800 font-semibold text-lg">
                                        সময়সূচী <span class="text-red-500">*</span>
                                    </label>
                                    <p class="text-gray-600 text-sm">কখন কাজ শুরু করতে পারবেন?</p>
                                </div>
                            </div>
                            
                            <div class="space-y-3">
                                <label class="flex items-center p-4 border-2 border-blue-600 rounded-xl cursor-pointer bg-blue-50 transition-all">
                                    <input type="radio" name="availability" value="today" class="w-5 h-5 text-blue-600" checked>
                                    <div class="ml-4">
                                        <span class="font-medium text-gray-800">আজ</span>
                                        <p class="text-gray-600 text-sm mt-1">আজকে কাজ শুরু করতে পারবেন</p>
                                    </div>
                                    <div class="ml-auto bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                        <i class="fas fa-bolt mr-1"></i>দ্রুত
                                    </div>
                                </label>
                                
                                <label class="flex items-center p-4 border-2 border-gray-300 rounded-xl cursor-pointer hover:border-blue-400 transition-all">
                                    <input type="radio" name="availability" value="tomorrow" class="w-5 h-5 text-blue-600">
                                    <div class="ml-4">
                                        <span class="font-medium text-gray-800">আগামীকাল</span>
                                        <p class="text-gray-600 text-sm mt-1">আগামীকাল কাজ শুরু করতে পারবেন</p>
                                    </div>
                                </label>
                                
                                <label class="flex items-center p-4 border-2 border-gray-300 rounded-xl cursor-pointer hover:border-blue-400 transition-all">
                                    <input type="radio" name="availability" value="specific" class="w-5 h-5 text-blue-600">
                                    <div class="ml-4">
                                        <span class="font-medium text-gray-800">নির্দিষ্ট তারিখ</span>
                                        <p class="text-gray-600 text-sm mt-1">আপনার সুবিধাজনক তারিখ নির্ধারণ করুন</p>
                                    </div>
                                </label>
                            </div>
                            
                            <div class="mt-4">
                                <input type="date" 
                                       class="w-full p-4 border-2 border-gray-300 rounded-xl text-lg">
                            </div>
                        </div>
                    </div>

                    <!-- Proposal Message -->
                    <div class="mb-10">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-edit text-blue-600 text-lg"></i>
                            </div>
                            <div>
                                <label class="block text-gray-800 font-semibold text-lg">
                                    আপনার প্রস্তাবনা
                                </label>
                                <p class="text-gray-600 text-sm">ভালো প্রস্তাবনা বিড জেতার সম্ভাবনা বাড়ায়</p>
                            </div>
                        </div>
                        
                        <textarea rows="6" 
                                  class="w-full p-5 border-2 border-gray-300 rounded-xl focus:border-blue-500 text-gray-800 transition-colors" 
                                  placeholder="আপনি কিভাবে এই কাজটি করবেন? আপনার অভিজ্ঞতা, টুলস, বা বিশেষ অফার সম্পর্কে লিখুন..."></textarea>

                        <Accordion :title="bidAvices.label" :items="bidAvices.items"/>
                    </div>

                    <!-- Submit Section -->
                    <div class="border-t border-gray-200 pt-8">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                            <div class="flex items-center">
                                <input type="checkbox" class="w-5 h-5 text-blue-600 rounded mr-3" checked>
                                <span class="font-medium text-gray-800">আমি শর্তাবলী ও নীতিমালা মেনে নিচ্ছি</span>
                            </div>
                            
                            <button type="submit" 
                                    class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-10 py-4 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center text-lg">
                                <i class="fas fa-paper-plane mr-3"></i>বিড জমা দিন
                            </button>
                        </div>
                        
                        <div class="mt-6 text-center text-gray-600 text-sm">
                            <i class="fas fa-shield-alt text-gray-400 mr-2"></i>
                            আপনার সকল তথ্য সুরক্ষিত রাখা হবে এবং গ্রাহক নির্বাচন না করা পর্যন্ত গোপন রাখা হবে
                        </div>
                    </div>
                </form>
            </div>
        </div>
</template>