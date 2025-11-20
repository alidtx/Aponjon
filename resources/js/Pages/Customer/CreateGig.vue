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
import { ref, computed } from 'vue'

const props = defineProps({
  districts: {
    type: Object,
    default: () => []  
  },
  zilas: {
    type: Object,
    default: () => []
  },
  categories: {
    type: Object,
    default: () => []
  }
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
    category:''
});

const selectedDivision = ref('')
const selectedDistrict = ref('')
const selectedUpazila = ref('')
const selectedEmergency = ref('')
const districtss = computed(() => props.districts.data || [])


const Options = [
    { value: 'normal', label: 'সাধারণ (২৪-৪৮ ঘন্টা)' },
    { value: 'urgent', label: 'জরুরি (১২-২৪ ঘন্টা)' },
    { value: 'emergency', label: 'ইমার্জেন্সি (৬-১২ ঘন্টা)' },
    { value: 'অনান্য', label: 'অনান্য' },
]



const submit=()=>{
    form.post(route('customer.gigs.store'), {
        
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
                                 :serviceCategories="props.categories"
                                />
                                <div class="mb-8">
                                    <h3 class="text-xl font-bold text-dark mb-6">টাস্কের বিস্তারিত</h3>
                                    <div class="space-y-6">
                                        <div>
                                            <InputLabel for="টাস্কের শিরোনাম" value="টাস্কের শিরোনাম" required />
                                            <TextInput type="text" class="w-full p-3" name="title"
                                                placeholder="উদা: বাড়ির জন্য ইলেকট্রিক ওয়্যারিং"
                                                v-model="form.title"
                                                />

                                        </div>
                                        <div>
                                            <InputLabel for="বিস্তারিত বর্ণনা" value="বিস্তারিত বর্ণনা" required />
                                            <TextArea class="w-full  p-3" name="description"
                                                placeholder="আপনার কাজের সম্পূর্ণ বিস্তারিত বর্ণনা দিন..." 
                                                v-model="form.description"
                                                />
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <InputLabel for="আনুমানিক বাজেট" value="আনুমানিক বাজেট (৳)" required />
                                                <TextInput type="number" class="w-full p-3" name="budget"
                                                    placeholder="উদা: বাড়ির জন্য ইলেকট্রিক ওয়্যারিং" 
                                                    v-model="form.budget"
                                                    />
                                            </div>
                                            <div>
                                                <InputLabel for="জরুরিতা" value="জরুরিতা"/>
                                                <SelectInput class="w-full p-3" defaultVal="জরুরিতা নির্বাচন করুন" name="schedule_for"
                                                    :options="Options" 
                                                    labelKey="label"  
                                                    valueKey="value"  
                                                    v-model="form.schedule_for"
                                                    />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-8">
                                    <h3 class="text-xl font-bold text-dark mb-6">লোকেশন তথ্য</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                        <div>
                                            <InputLabel for="বিভাগ" value="বিভাগ"   required/>
                                             <SelectInput class="w-full p-3 " defaultVal="বিভাগ নির্বাচন করুন" name="district_id"
                                                :options="districts" 
                                                 v-model="form.district_id"
                                                />
                                        </div>
                                        <div>
                                            <InputLabel for="জেলা" value="জেলা" required/>
                                             <SelectInput class="w-full p-3" defaultVal="জেলা নির্বাচন করুন" name="zila_id"
                                                :options="districts" 
                                                v-model="form.zila_id"
                                                />
                                        </div>
                                        <div>
                                            <InputLabel for="উপজীলা" value="উপজীলা" required/>
                                           <SelectInput class="w-full p-3" defaultVal="উপজীলা নির্বাচন করুন" name="upozila_id"
                                                :options="districts"
                                                 v-model="form.upozila_id" 
                                                />
                                        </div>

                                    </div>
                                </div>
                                <div class="md:col-span-2">
                                    <div>
                                        <InputLabel for="সম্পূর্ণ ঠিকানা" value="সম্পূর্ণ ঠিকানা" required />
                                        <TextArea class="w-full p-3" placeholder="বাড়ি নম্বর, রোড নম্বর, এলাকা..."  name="location_address"
                                        v-model="form.location_address"
                                        />
                                    </div>
                                </div>

                                <!-- <div class="mb-8">
                                    <h3 class="text-xl font-bold text-dark mb-6">যোগাযোগ তথ্য</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <InputLabel for="মোবাইল নম্বর" value="মোবাইল নম্বর" required />
                                            <TextInput type="number" class="w-full p-3" placeholder="মোবাইল নম্বর" name=""
                                            v-model="selectedDivision"
                                            />
                                        </div>
                                    </div>
                                </div> -->
                                <PrimaryButton type="submit">
                                    অ্যাকাউন্ট তৈরি করুন
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