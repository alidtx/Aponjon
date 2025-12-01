<script setup>
import { Head, useForm, router } from '@inertiajs/vue3'
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
import { ref, computed } from 'vue'
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    districts: {
        type: Object,
        default: () => ({})
    },
    zilas: {
        type: Object,
        default: () => ({})
    },
    categories: {
        type: Object,
        default: () => []
    },
    success: {
        type: String,
        default: ''
    }
})

const districtsData = computed(() => {
    const data = props.districts?.data || props.districts
    return data || []
})

const allZilasData = computed(() => {
    const data = props.zilas?.data || props.zilas
    return data || []
})

const form = useForm({
    title: '',
    description: '',
    budget: '',
    emergency: '',
    district_id: '',
    zila_id: '',
    upozila_id: '',
    location_address: '',
    category_id: ''
});

const filteredZilaList = ref([])
const filteredUpozilaList = ref([])
const showSuccessMessage = ref(false)
const backendMessage = ref('')

const Options = [
    { value: 'normal', label: 'সাধারণ (২৪-৪৮ ঘন্টা)' },
    { value: 'urgent', label: 'জরুরি (১২-২৪ ঘন্টা)' },
    { value: 'emergency', label: 'ইমার্জেন্সি (৬-১২ ঘন্টা)' },
    { value: 'other', label: 'অনান্য' },
]

const getZilasByDistric = (districtId) => {
    if (!districtId) {
        filteredZilas.value = []
        return
    }

    const districtsArray = JSON.parse(JSON.stringify(districtsData.value))
    const zilasArray = JSON.parse(JSON.stringify(allZilasData.value))
    const selectedDistrict = districtsArray.find(district => district.id == districtId)

    if (selectedDistrict && selectedDistrict.zilas && selectedDistrict.zilas.length > 0) {
        filteredZilaList.value = selectedDistrict.zilas
        return
    }

    const zilas = zilasArray.filter(zila => {
        const districtIdField = zila.district_id || zila.district?.id
        return districtIdField == districtId
    })
    filteredZilaList.value = zilas
}

const getUpozilasByZila = (zilaId) => {
    if (!zilaId) {
        filteredUpozilas.value = []
        return
    }

    const zilasArray = JSON.parse(JSON.stringify(allZilasData.value))
    const selectedZila = zilasArray.find(zila => zila.id == zilaId)
    if (selectedZila && selectedZila.upozilas) {
        filteredUpozilaList.value = selectedZila.upozilas
    } else {
        filteredUpozilaList.value = []
    }
}

const submit = () => {
    form.post(route('customer.gigs.store'), {
        onSuccess: (res) => {
            if (res.props.flash?.type==='success'){
            showSuccessMessage.value = true
            backendMessage.value = res.props.flash?.message  || 'আপনার গিগ সফলভাবে তৈরি হয়েছে!'
            form.reset()
            }
        },
    });
}

const createAnotherGig = () => {
    showSuccessMessage.value = false
    backendMessage.value = ''
}

const goToDashboard = () => {
    router.visit(route('customer.dashboard'))
}
</script>

<template>
    <CustomerDefaultLayout>
        <Head title="গিগ তৈরি" />
        <div class="min-h-screen py-8">
            <div class="max-w-6xl mx-auto px-4">
                <PageTitle />
                
                <!-- Success Message Section -->
                <div v-if="showSuccessMessage" class="mb-8">
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-green-800">
                                    সফল!
                                </h3>
                                <div class="mt-2 text-sm text-green-700">
                                    <p>{{ backendMessage }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Boxes -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Create Another Gig Box -->
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 text-center hover:shadow-md transition-shadow cursor-pointer"
                             @click="createAnotherGig">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                আরেকটি গিগ তৈরি করুন
                            </h3>
                            <p class="text-sm text-gray-600">
                                একই কাস্টমার হিসেবে আরেকটি নতুন গিগ পোস্ট করুন
                            </p>
                            <div class="mt-4">
                                <span class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors">
                                    নতুন গিগ তৈরি করুন
                                </span>
                            </div>
                        </div>

                        <!-- Go to Dashboard Box -->
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 text-center hover:shadow-md transition-shadow cursor-pointer"
                             @click="goToDashboard">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                ড্যাশবোর্ডে যান
                            </h3>
                            <p class="text-sm text-gray-600">
                                আপনার ড্যাশবোর্ডে ফিরে যান এবং অন্যান্য গিগগুলো দেখুন
                            </p>
                            <div class="mt-4">
                                <span class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transition-colors">
                                    ড্যাশবোর্ড দেখুন
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gig Creation Form (Hidden when success message is shown) -->
                <div v-if="!showSuccessMessage" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-md p-8">
                            <form id="serviceRequestForm" @submit.prevent="submit">
                                <Services 
                                :serviceCategories="categories" 
                                v-model="form.category_id" 
                                :error="form.errors.category_id" />

                                <div class="mb-4">
                                    <h3 class="text-xl font-bold text-dark mb-6">টাস্কের বিস্তারিত</h3>
                                    <div class="space-y-6">
                                        <div>
                                            <InputLabel for="title" value="টাস্কের শিরোনাম" required />
                                            <TextInput id="title" type="text" class="w-full p-3"
                                                placeholder="উদা: বাড়ির জন্য ইলেকট্রিক ওয়্যারিং" v-model="form.title"
                                                :error="form.errors.title" />
                                            <InputError class="mt-2" :message="form.errors.title" />
                                        </div>
                                        <div>
                                            <InputLabel for="description" value="বিস্তারিত বর্ণনা" required />
                                            <TextArea id="description" class="w-full p-3"
                                                placeholder="আপনার কাজের সম্পূর্ণ বিস্তারিত বর্ণনা দিন..."
                                                v-model="form.description" :error="form.errors.description" />
                                                <InputError class="mt-2" :message="form.errors.description" />
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <InputLabel for="budget" value="আনুমানিক বাজেট (৳)" required />
                                                <TextInput id="budget" type="number" class="w-full p-3"
                                                    placeholder="আনুমানিক বাজেট লিখুন" v-model="form.budget"
                                                    :error="form.errors.budget" />
                                                    <InputError class="mt-2" :message="form.errors.budget" />
                                            </div>
                                            <div>
                                                <InputLabel for="emergency" value="জরুরিতা" required/>
                                                <SelectInput id="emergency" class="w-full p-3"
                                                    defaultVal="জরুরিতা নির্বাচন করুন" :options="Options"
                                                    labelKey="label" valueKey="value" v-model="form.emergency"
                                                    :error="form.errors.schedule_for" />
                                                    <InputError class="mt-2" :message="form.errors.emergency" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h3 class="text-xl font-bold text-dark mb-6">লোকেশন তথ্য</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                        <div>
                                            <InputLabel for="district_id" value="বিভাগ" required />
                                            <SelectInput id="district_id" class="w-full p-3"
                                                defaultVal="বিভাগ নির্বাচন করুন" :options="districtsData"
                                                labelKey="name" valueKey="id"
                                                @change="getZilasByDistric(form.district_id)" v-model="form.district_id"
                                                :error="form.errors.district_id" />
                                                <InputError class="mt-2" :message="form.errors.district_id" />
                                        </div>
                                        <div>
                                            <InputLabel for="zila_id" value="জেলা" required />
                                            <SelectInput id="zila_id" class="w-full p-3" defaultVal="জেলা নির্বাচন করুন"
                                                :options="filteredZilaList" labelKey="name" valueKey="id"
                                                @change="getUpozilasByZila(form.zila_id)" v-model="form.zila_id"
                                                :error="form.errors.zila_id"
                                                :disabled="!form.district_id || filteredZilaList.length === 0" />
                                            <small class="text-gray-500 text-xs mt-1 block" v-if="form.district_id">
                                                পাওয়া গেছে: {{ filteredZilaList.length }} টি জেলা
                                            </small>
                                            <InputError class="mt-2" :message="form.errors.zila_id" />
                                        </div>
                                        <div>
                                            <InputLabel for="upozila_id" value="উপজেলা" required />
                                            <SelectInput id="upozila_id" class="w-full p-3"
                                                defaultVal="উপজেলা নির্বাচন করুন" :options="filteredUpozilaList"
                                                labelKey="name" valueKey="id" v-model="form.upozila_id"
                                                :error="form.errors.upozila_id"
                                                :disabled="!form.zila_id || filteredUpozilaList.length === 0" />
                                            <small class="text-gray-500 text-xs mt-1 block" v-if="form.zila_id">
                                                পাওয়া গেছে: {{ filteredUpozilaList.length }} টি উপজেলা
                                            </small>
                                            <InputError class="mt-2" :message="form.errors.upozila_id" />
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <InputLabel for="location_address" value="সম্পূর্ণ ঠিকানা" required />
                                    <TextArea id="location_address" class="w-full p-3"
                                        placeholder="বাড়ি নম্বর, রোড নম্বর, এলাকা..." v-model="form.location_address"
                                        :error="form.errors.location_address" />
                                        <InputError class="mt-2" :message="form.errors.location_address" />
                                </div>

                                <PrimaryButton type="submit" :disabled="form.processing">
                                    <span v-if="form.processing">সাবমিট হচ্ছে...</span>
                                    <span v-else>গিগ তৈরি করুন</span>
                                </PrimaryButton>
                            </form>
                        </div>
                    </div>

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