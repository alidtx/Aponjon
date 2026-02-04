<script setup>
import Accordion from '@/Components/Accordion.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { ref, computed, watch, isProxy } from 'vue';
import { useTimeLeft } from '@/composables/useTimeLeft'
import { useTimeAgo } from '@/composables/useTimeAgo'
import { useBidsAverageAmount } from '@/composables/useBidsAverageAmount';
import InputLabel from '@/Components/InputLabel.vue';
import BaseParagraph from '@/Components/BaseParagraph.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import BaseNumberInput from '@/Components/BaseNumberInput.vue';
import Checkbox from '@/Components/Checkbox.vue';
import TextArea from '@/Components/TextArea.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';

const page = usePage()
const bidAvices = page.props.bid_advices
const hours = [1, 2, 3, 4, 5, 6, 7, 8]

const props = defineProps({
    bidDetails: {
        type: Object,
        required: true
    }
})

const form = useForm({
    task_id: props.bidDetails.data?.id,
    bid_amount: '',
    availability: 'today',
    specific_date: '',
    estimated_hours: 1,
    proposal: '',
    terms_accepted: true,
})

const showSpecificDate = ref(false)

watch(() => form.availability, (newValue) => {
     showSpecificDate.value = newValue === 'specific'
    if (newValue !== 'specific') {
        form.specific_date = ''
    }
})

const shortAddress = computed(() => {
    const address = props.bidDetails.data?.location_address
    if (!address) return ''
    return address.split(' ').slice(0, 3).join(' ')
})

const serviceCharge = computed(() => {
    if (!form.bid_amount || isNaN(form.bid_amount)) return '0'
    return Math.round(form.bid_amount * 0.05)
})

const deadline = ref(props.bidDetails.data?.bidding_ends_at)
const createdAt = ref(props.bidDetails.data?.created_at)
const timeLeft = useTimeLeft(deadline)
const timeAgo = useTimeAgo(createdAt)
const average = useBidsAverageAmount(props.bidDetails.data?.bid);

const submit = () => {
    form.post(route('bid.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
        },
        onError: (errors) => {
            console.error('Submission error:', errors)
        }
    });
}


</script>

<template>
    <div class="lg:col-span-2 animate-fade-in">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-primary text-white p-6 md:p-8 rounded-lg shadow-md">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-white mb-3">বিড সাবমিট করুন</h2>
                        <div class="flex flex-wrap items-center gap-2 mb-4">
                            <span
                                class="text-blue-100 bg-blue-800 bg-opacity-30 px-3 py-1 rounded-full text-sm font-medium">
                                <BaseIcon class="fas fa-bolt mr-1" />কাজের নংঃ {{ props.bidDetails.data.task_number }}
                            </span>
                            <span
                                class="text-blue-100 bg-blue-800 bg-opacity-30 px-3 py-1 rounded-full text-sm font-medium">
                                <BaseIcon class="fas fa-calendar mr-1" />{{ timeLeft }}
                            </span>
                        </div>
                    </div>
                    <div class="text-right hidden md:block">
                        <div class="text-blue-200 text-sm">টাস্ক পোস্ট হয়েছে</div>
                        <div class="text-white font-bold">{{ timeAgo }}</div>
                    </div>
                </div>
                <div class="mt-6 bg-blue-800 bg-opacity-30 rounded-lg p-4">
                    <h3 class="text-white font-bold text-lg mb-3">{{ props.bidDetails.data?.title }}</h3>
                    <p class="text-blue-100 mb-4">{{ props.bidDetails.data?.description }}</p>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <BaseParagraph class="text-blue-200 text-sm">গ্রাহকের বাজেট</BaseParagraph>
                            <p class="text-white font-bold text-lg">৳{{ Math.round(props.bidDetails.data?.budget) }}</p>
                        </div>
                        <div>
                            <BaseParagraph class="text-blue-200 text-sm">গড় মূল্য</BaseParagraph>
                            <p class="text-white font-bold text-lg">৳{{ average }}</p>
                        </div>
                        <div>
                            <BaseParagraph class="text-blue-200 text-sm">লোকেশন</BaseParagraph>
                            <p class="text-white font-bold text-lg">{{ shortAddress }}</p>
                        </div>
                        <div>
                            <BaseParagraph class="text-blue-200 text-sm">বিডস</BaseParagraph>
                            <p class="text-white font-bold text-lg">{{ props.bidDetails.data?.bid?.length }} টি</p>
                        </div>
                    </div>
                </div>
            </div>
            <form class="p-6 md:p-8" @submit.prevent="submit">
                <div class="mb-10">
                    <div class="flex items-start mb-6">
                        <div
                            class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                            <BaseIcon class="fas fa-money-bill-wave text-blue-600 text-xl" />
                        </div>
                        <div class="flex-grow">
                            <InputLabel class="block text-gray-800 font-semibold text-xl mb-2"
                                value="আপনার প্রস্তাবিত মূল্য" required />
                            <BaseParagraph class="text-gray-600">গ্রাহকের বাজেটের সাথে মিলিয়ে প্রস্তাব দিন। কম মূল্যে
                                ভালো সার্ভিস দিতে পারলে বিড জেতার সম্ভাবনা বাড়ে।</BaseParagraph>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <InputLabel class="block text-gray-700 font-medium mb-3" value="আপনার প্রস্তাবিত টাকা (৳)"
                                required />
                            <BaseNumberInput type="number" placeholder="৳" class="w-full p-3" v-model="form.bid_amount"
                                :error="form.errors.bid_amount" min="1" />
                            <InputError class="mt-2" :message="form.errors.bid_amount" />
                            <BaseParagraph class="text-sm text-gray-500 mt-2">
                                একবার বিড জমা দিলে তা পরিবর্তন করা যাবে না
                            </BaseParagraph>
                        </div>
                        <div>
                            <InputLabel class="block text-gray-700 font-medium mb-3" value="সার্ভিস চার্জ (৫%)" />
                            <BaseNumberInput type="number"
                                class="w-full p-3 bg-gray-100 text-gray-500 cursor-not-allowed border-gray-300"
                                placeholder="৳" :value="serviceCharge" disabled="true" />
                            <BaseParagraph class="text-sm text-gray-500 mt-2">
                                এই চার্জ প্ল্যাটফর্ম ফি হিসেবে নেয়া হয়
                            </BaseParagraph>
                        </div>
                    </div>

                    <!-- Budget comparison remains the same -->
                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-gray-800 font-semibold text-lg">বাজেট তুলনা</span>
                            <div class="text-right">
                                <span class="font-bold text-green-600 text-lg">৳৫০০ কম</span>
                                <BaseParagraph class="text-sm text-gray-600">গ্রাহকের সর্বনিম্ন বাজেট থেকে
                                </BaseParagraph>
                            </div>
                        </div>
                        <div class="h-4 bg-gray-200 rounded-full overflow-hidden relative mb-3">
                            <div class="h-full bg-gradient-to-r from-green-500 via-yellow-500 to-red-500 w-full"></div>
                            <div class="h-8 w-8 bg-blue-700 rounded-full border-4 border-white shadow-lg absolute -top-2"
                                style="left: 45%;"></div>
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

                <!-- Estimated Hours & Availability -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                    <!-- Estimated Hours -->
                    <div>
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <BaseIcon class="fas fa-clock text-blue-600 text-lg" />
                            </div>
                            <div>
                                <InputLabel class="block text-gray-800 font-semibold text-lg" value="আনুমানিক সময়"
                                    required />
                                <BaseParagraph class="text-gray-600 text-sm">কাজ শেষ করতে কত সময় লাগবে?</BaseParagraph>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <InputLabel v-for="hour in hours" :key="hour" class="relative cursor-pointer"
                                :class="hour === 8 ? 'col-span-2' : ''">
                                <input type="radio" v-model="form.estimated_hours" class="hidden peer" :value="hour"
                                    :checked="hour === 1" />

                                <div class="h-full p-4 border-2 border-gray-300 rounded-xl text-center
             transition-all hover:border-blue-400
             peer-checked:border-blue-600 peer-checked:bg-blue-50">
                                    <div class="text-2xl font-bold text-gray-800">
                                        {{ hour === 8 ? '8+' : hour }}
                                    </div>
                                    <div class="text-gray-600">
                                        {{ hour === 8 ? 'দীর্ঘমেয়াদী' : 'ঘন্টা' }}
                                    </div>
                                </div>
                            </InputLabel>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center mb-8">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <BaseIcon class="fas fa-calendar-alt text-blue-600 text-lg" />
                            </div>
                            <div>
                                <label class="block text-gray-800 font-semibold text-lg">
                                    সময়সূচী <span class="text-red-500">*</span>
                                </label>
                                <BaseParagraph class="text-gray-600 text-sm">কখন কাজ শুরু করতে পারবেন?</BaseParagraph>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label
                                class="flex items-center p-4 border-2 border-blue-600 rounded-xl cursor-pointer bg-blue-50 transition-all">
                                <input type="radio"  name="availability" value="today" :v-model="form.availability"
                                    class="w-5 h-5 text-blue-600" :checked="form.availability==='today'" />
                                <div class="ml-4">
                                    <span class="font-medium text-gray-800">আজ</span>
                                    <BaseParagraph class="text-gray-600 text-sm mt-1">আজকে কাজ শুরু করতে পারবেন
                                    </BaseParagraph>
                                </div>
                                <div
                                    class="ml-auto bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                    <BaseIcon class="fas fa-bolt mr-1" />দ্রুত
                                </div>
                            </label>

                            <label
                                class="flex items-center p-4 border-2 border-gray-300 rounded-xl cursor-pointer hover:border-blue-400 transition-all">
                                <input type="radio" name="availability" value="tomorrow" v-model="form.availability"
                                    class="w-5 h-5 text-blue-600" />
                                <div class="ml-4">
                                    <span class="font-medium text-gray-800">আগামীকাল</span>
                                    <BaseParagraph class="text-gray-600 text-sm mt-1">আগামীকাল কাজ শুরু করতে পারবেন
                                    </BaseParagraph>
                                </div>
                            </label>

                            <label
                                class="flex items-center p-4 border-2 border-gray-300 rounded-xl cursor-pointer hover:border-blue-400 transition-all">
                                <input type="radio" name="availability" value="specific" v-model="form.availability"
                                    class="w-5 h-5 text-blue-600"/>
                                <div class="ml-4">
                                    <span class="font-medium text-gray-800">নির্দিষ্ট তারিখ</span>
                                    <BaseParagraph class="text-gray-600 text-sm mt-1">আপনার সুবিধাজনক তারিখ নির্ধারণ
                                        করুন</BaseParagraph>
                                </div>
                            </label>
                        </div>

                        <div class="mt-4" v-if="showSpecificDate">
                            <TextInput type="date" class="w-full p-3" v-model="form.specific_date"
                                :min="new Date().toISOString().split('T')[0]" />
                            <InputError class="mt-2" :message="form.errors.specific_date" />
                        </div>
                    </div>
                </div>

                <!-- Proposal -->
                <div class="mb-10">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <BaseIcon class="fas fa-edit text-blue-600 text-lg" />
                        </div>
                        <div>
                            <label class="block text-gray-800 font-semibold text-lg">আপনার প্রস্তাবনা</label>
                            <BaseParagraph class="text-gray-600 text-sm">ভালো প্রস্তাবনা বিড জেতার সম্ভাবনা বাড়ায়
                            </BaseParagraph>
                        </div>
                    </div>
                    <div>
                        <textarea rows="6" v-model="form.proposal"
                            class="w-full p-5 border-2 border-gray-300 rounded-xl focus:border-blue-500 text-gray-800 transition-colors"
                            placeholder="আপনি কিভাবে এই কাজটি করবেন? আপনার অভিজ্ঞতা, টুলস, বা বিশেষ অফার সম্পর্কে লিখুন..."
                            :error="form.errors.proposal"></TextArea>
                        <InputError class="mt-2" :message="form.errors.proposal" />
                    </div>
                    <Accordion :title="bidAvices.label" :items="bidAvices.items" />
                </div>
                <div class="border-t border-gray-200 pt-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">

                        <div class="md:col-span-2 flex items-center">
                            <input type="checkbox" class="w-5 h-5 text-blue-600 rounded mr-3"
                                v-model="form.terms_accepted" checked />
                            <span class="font-medium text-gray-800">
                                আমি শর্তাবলী ও নীতিমালা মেনে নিচ্ছি
                            </span>
                            <InputError class="mt-2" :message="form.errors.terms_accepted" />
                        </div>
                        <PrimaryButton type="submit"
                            class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-4 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center text-lg"
                            :disabled="form.processing">
                            <BaseIcon class="fas fa-paper-plane mr-3" />
                            <span v-if="form.processing">সাবমিট করা হচ্ছে...</span>
                            <span v-else>কাজ জমা দিন</span>
                        </PrimaryButton>
                    </div>

                    <div class="mt-6 text-center text-gray-600 text-sm">
                        <BaseIcon class="fas fa-shield-alt text-gray-400 mr-2" />
                        আপনার সকল তথ্য সুরক্ষিত রাখা হবে এবং গ্রাহক নির্বাচন না করা পর্যন্ত গোপন রাখা হবে
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>