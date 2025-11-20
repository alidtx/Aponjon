<script setup>
import { Head, useForm } from '@inertiajs/vue3'
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
import { ref, computed, watch, onMounted } from 'vue'

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
    schedule_for: '',
    district_id: '', 
    zila_id: '', 
    upozila_id: '', 
    location_address: '', 
    category: ''
});

const filteredZilaList = ref([]) 
const filteredUpozilaList = ref([]) 

const Options = [
    { value: 'normal', label: 'সাধারণ (২৪-৪৮ ঘন্টা)' },
    { value: 'urgent', label: 'জরুরি (১২-২৪ ঘন্টা)' },
    { value: 'emergency', label: 'ইমার্জেন্সি (৬-১২ ঘন্টা)' },
    { value: 'other', label: 'অনান্য' },
]

const getZilasByDistric=(districtId)=>{
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

const getUpozilasByZila=(zilaId) =>{
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
        onSuccess: () => {
            form.reset()
        },
        onError: (errors) => {
        }
    });
}
</script>

<template>
    <CustomerDefaultLayout>
        <Head title="গিগ তৈরি" />
        <div class="min-h-screen py-8">
            <div class="max-w-6xl mx-auto px-4">
                <PageTitle />
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-md p-8">
                            <form id="serviceRequestForm" @submit.prevent="submit">
                                <Services 
                                    :serviceCategories="categories"
                                    v-model="form.category"
                                />
                                
                                <div class="mb-8">
                                    <h3 class="text-xl font-bold text-dark mb-6">টাস্কের বিস্তারিত</h3>
                                    <div class="space-y-6">
                                        <div>
                                            <InputLabel for="title" value="টাস্কের শিরোনাম" required />
                                            <TextInput 
                                                id="title"
                                                type="text" 
                                                class="w-full p-3" 
                                                placeholder="উদা: বাড়ির জন্য ইলেকট্রিক ওয়্যারিং"
                                                v-model="form.title"
                                                :error="form.errors.title"
                                            />
                                        </div>
                                        <div>
                                            <InputLabel for="description" value="বিস্তারিত বর্ণনা" required />
                                            <TextArea 
                                                id="description"
                                                class="w-full p-3" 
                                                placeholder="আপনার কাজের সম্পূর্ণ বিস্তারিত বর্ণনা দিন..." 
                                                v-model="form.description"
                                                :error="form.errors.description"
                                            />
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <InputLabel for="budget" value="আনুমানিক বাজেট (৳)" required />
                                                <TextInput 
                                                    id="budget"
                                                    type="number" 
                                                    class="w-full p-3" 
                                                    placeholder="আনুমানিক বাজেট লিখুন"
                                                    v-model="form.budget"
                                                    :error="form.errors.budget"
                                                />
                                            </div>
                                            <div>
                                                <InputLabel for="schedule_for" value="জরুরিতা"/>
                                                <SelectInput 
                                                    id="schedule_for"
                                                    class="w-full p-3" 
                                                    defaultVal="জরুরিতা নির্বাচন করুন" 
                                                    :options="Options" 
                                                    labelKey="label"  
                                                    valueKey="value"  
                                                    v-model="form.schedule_for"
                                                    :error="form.errors.schedule_for"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-8">
                                    <h3 class="text-xl font-bold text-dark mb-6">লোকেশন তথ্য</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                        <div>
                                            <InputLabel for="district_id" value="বিভাগ" required/>
                                            <SelectInput 
                                                id="district_id"
                                                class="w-full p-3" 
                                                defaultVal="বিভাগ নির্বাচন করুন" 
                                                :options="districtsData" 
                                                labelKey="name"
                                                valueKey="id"
                                                @change="getZilasByDistric(form.district_id)"
                                                v-model="form.district_id"
                                                :error="form.errors.district_id"
                                            />
                                        </div>
                                        <div>
                                            <InputLabel for="zila_id" value="জেলা" required/>
                                            <SelectInput 
                                                id="zila_id"
                                                class="w-full p-3" 
                                                defaultVal="জেলা নির্বাচন করুন" 
                                                :options="filteredZilaList" 
                                                labelKey="name"
                                                valueKey="id"
                                                @change="getUpozilasByZila(form.zila_id)"
                                                v-model="form.zila_id"
                                                :error="form.errors.zila_id"
                                                :disabled="!form.district_id || filteredZilaList.length === 0"
                                            />
                                            <small class="text-gray-500 text-xs mt-1 block" v-if="form.district_id">
                                                পাওয়া গেছে: {{ filteredZilaList.length }} টি জেলা
                                            </small>
                                        </div>
                                        <div>
                                            <InputLabel for="upozila_id" value="উপজেলা" required/>
                                            <SelectInput 
                                                id="upozila_id"
                                                class="w-full p-3" 
                                                defaultVal="উপজেলা নির্বাচন করুন" 
                                                :options="filteredUpozilaList" 
                                                labelKey="name"
                                                valueKey="id"
                                                v-model="form.upozila_id"
                                                :error="form.errors.upozila_id"
                                                :disabled="!form.zila_id || filteredUpozilaList.length === 0"
                                            />
                                            <small class="text-gray-500 text-xs mt-1 block" v-if="form.zila_id">
                                                পাওয়া গেছে: {{ filteredUpozilaList.length }} টি উপজেলা
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-8">
                                    <InputLabel for="location_address" value="সম্পূর্ণ ঠিকানা" required />
                                    <TextArea 
                                        id="location_address"
                                        class="w-full p-3" 
                                        placeholder="বাড়ি নম্বর, রোড নম্বর, এলাকা..." 
                                        v-model="form.location_address"
                                        :error="form.errors.location_address"
                                    />
                                </div>

                                <PrimaryButton 
                                    type="submit" 
                                    :disabled="form.processing"
                                    class="w-full md:w-auto"
                                >
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