<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import PageHeadline from '@/Components/PageHeadline.vue';
import ProgressBar from './Partials/ProgressBar.vue';
import Benefits from './Partials/Benefits.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import BaseNumberInput from '@/Components/BaseNumberInput.vue';
import LocationSelector from '@/Components/LocationSelector.vue';
import SelectInput from '@/Components/SelectInput.vue';
import Upolad from '@/Components/Upolad.vue';
import Modal from '@/Components/Modal.vue';
import TermsAndConditions from './Partials/TermsAndConditions.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Checkbox from '@/Components/Checkbox.vue';
import TextArea from '@/Components/TextArea.vue';
import TagsInput from '@/Components/TagsInput.vue';


const props = defineProps({

    districts: {
        type: Object,
        default: () => ({})
    },
    zilas: {
        type: Object,
        default: () => ({})
    },

})

const sliderValue = ref(250)
const isOpenTermsModal = ref(false)

const form = useForm({
    nid_number:'',
    skills:'',
    experience:'',
    district_id: '',
    zila_id: '',
    upozila_id: '',
    bio: '',
    hourly_rate: sliderValue.value,
    nid_front: '',
    nid_back: '',
    is_terms_and_condition_accept: false
});

const placeholder=`৮ বছরের অভিজ্ঞতা নিয়ে আমি একজন প্রফেশনাল ইলেকট্রিশিয়ান। বাসা-বাড়ি, অফিস, দোকান - সকল ধরনের ইলেকট্রিক্যাল কাজে আমি পারদর্শী। আমি শুধু মেরামতই নয়, নতুন ওয়্যারিং,ইলেকট্রিক্যাল ডিজাইন এবং এনার্জি এফিসিয়েন্ট সলিউশনও প্রদান করি।`

const Options = [
    { value: '1', label: '১ বছর' },
    { value: '2', label: '২ বছর' },
    { value: '3', label: '৩ বছর' },
    { value: '4', label: '৪ বছর' },
    { value: '5', label: '৫+ বছর' },
]

function rangeValue(event) {
    sliderValue.value = event.target.value
}

const acceptTerms = () => {
    form.is_terms_and_condition_accept = true
    isOpenTermsModal.value = false

}

const submit = () =>{
     console.log('dd')
    form.post(route('tasker.store.profile'),{

    })
}


</script>



<template>
    <DefaultLayout>

        <Head title="টাস্কার" />
        <div class="max-w-4xl mx-auto px-4">
            <PageHeadline title="টাস্কার হিসেবে আপনার প্রফাইল" highlight="কমপ্লিট করুন"
                description="আপনার দক্ষতা ব্যবহার করে আয় করুন এবং মানুষকে সাহায্য করুন।" />
            <ProgressBar />
            <div class="bg-white rounded-lg shadow-md p-8">
                <form id="taskerRegistrationForm" @submit.prevent="submit">
                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-dark mb-6">ব্যক্তিগত তথ্য</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <InputLabel for="name" value="পূর্ণ নাম" />
                                <TextInput  type="text" class="w-full p-3"
                                    placeholder="আপনার পূর্ণ নাম লিখুন" 
                                     readonly="true"  
                                    />
                            </div>
                            <div>
                                <InputLabel for="number" value="মোবাইল নম্বর" required />
                                <TextInput v-model="form.phone_number"  type="number" class="w-full p-3" placeholder="আপনার ফোন নম্বর লিখুন" 
                                 readonly="true"
                                />
                            </div>
                            <div>
                                <InputLabel for="email" value="ইমেইল" required />
                                <TextInput v-model="form.email" type="email" class="w-full p-3" placeholder="আপনার ইমেইল লিখুন"  readonly="true"/>
                            </div>
                            <div>
                                <InputLabel for="nid_number" value="এনআইডি নম্বর" required />
                                <BaseNumberInput v-model="form.nid_number" :error="form.errors.nid_number" type="number" class="w-full p-3"
                                    placeholder="জাতীয় পরিচয়পত্র নম্বর" />
                                <InputError class="mt-2" :message="form.errors.nid_number"/>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4"> 
                             <InputLabel for="about" value="আপনার সম্পর্কে লিখুন" required />
                              <TextArea  class="w-full p-3" 
                                        :placeholder="placeholder" v-model="form.bio"
                                        :error="form.errors.about"  />
                          <InputError class="mt-2" :message="form.errors.bio"/>
                        </div>
                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-dark mb-6">লোকেশন তথ্য</h3>
                        <LocationSelector  :districts="districts" :zilas="zilas" v-model:districtId="form.district_id"
                            v-model:zilaId="form.zila_id" v-model:upozilaId="form.upozila_id" :errors="form.errors" />
                    </div>
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-dark mb-6">আপনার দক্ষতা ও সেবা</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <InputLabel for="skils" value="দক্ষাতা" required />
                                <TagsInput v-model="form.skills" :errors="form.errors" placeholder="আপনি কি কাজে দক্ষ ?" />
                                <InputError class="mt-2" :message="form.errors.skills"/>
                            </div>
                            <div>
                                <InputLabel for="experience" value="অবিজ্ঞতা" required />
                                <SelectInput v-model="form.experience" :errors="form.errors" :options="Options" class="w-full p-3"
                                    defaultVal="এই কাজে কত বছরের অবিজ্ঞ্য" labelKey="label" valueKey="value" />
                                <InputError class="mt-2" :message="form.errors.experience"/>
                            </div>
                        </div>
                        <div class="mb-6">
                            <label class="block text-dark font-medium mb-2">আপনার ঘণ্টাপ্রতি রেট (৳)</label>
                            <div class="flex items-center">
                                <input  type="range" :errors="form.errors"   min="100" max="2000" step="50" class="flex-1" v-model="sliderValue"
                                    @input="rangeValue" >
                                <span class="ml-4 text-lg font-bold text-primary">৳<span id="rateValue">{{ sliderValue
                                        }}</span></span>
                            </div>
                            <InputError class="mt-2" :message="form.errors.sliderValue"/>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-dark mb-6">ডকুমেন্ট আপলোড</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <InputLabel for="document" value="এনআইডি ফ্রন্ট সাইড" required />
                                <Upolad v-model="form.nid_front" :errors="form.errors" acceptedType=".jpg,.jpeg,.png,.gif,.svg,.pdf" />
                                <InputError class="mt-2" :message="form.errors.nid_front"/>
                            </div>
                            <div>
                                <InputLabel for="document" value="এনআইডি ব্যাক সাইড" required />
                                <Upolad v-model="form.nid_back" :errors="form.errors" acceptedType=".jpg,.jpeg,.png,.gif,.svg,.pdf" />
                                <InputError class="mt-2" :message="form.errors.nid_back"/>
                            </div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <div class="flex items-start">
                            <Checkbox class="w-4 h-4 mt-1" :errors="form.errors"
                            :checked="form.is_terms_and_condition_accept"
                            :disabled="form.is_terms_and_condition_accept"
                             @click.prevent="isOpenTermsModal = true" />
                            <label class="ml-2 text-gray-700">
                                আমি <a href="#" @click.prevent="isOpenTermsModal = true"
                                    class="text-primary hover:underline">টার্মস অ্যান্ড কন্ডিশন</a> পড়েছি এবং সম্মতি
                                দিচ্ছি
                            </label>
                        </div>
                        <InputError class="mt-2" :message="form.errors.is_terms_and_condition_accept"/>
                    </div>

                    <PrimaryButton type="submit"
                        class="w-full bg-primary text-white py-3 rounded-lg hover:bg-blue-700 font-medium text-lg">
                        রেজিস্টার সম্পন্ন করুন
                    </PrimaryButton>
                </form>
            </div>
            <Benefits />
        </div>
        <Modal maxWidth="md" :show="isOpenTermsModal" @close="isOpenTermsModal = false" closeable>
            <TermsAndConditions @accepted="acceptTerms" />
        </Modal>

    </DefaultLayout>
</template>