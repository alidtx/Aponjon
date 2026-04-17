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
import SelectInput from '@/Components/SelectInput.vue';
import Upolad from '@/Components/Upolad.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TagsInput from '@/Components/TagsInput.vue';
import LocationSelector from '@/Components/LocationSelector.vue';
import { toast } from 'vue3-toastify'


const props = defineProps({

    districts: {
        type: Object,
        default: () => ({})
    },
    zilas: {
        type: Object,
        default: () => ({})
    },
    loggedInUser: {
        type: Object,
        default: () => ({})
    }

})


const form = useForm({
       nid_number: '',
       skills: '',
       experience: '',
       district_id: '',
       zila_id: '',
       upozila_id: '',
       bio: '',
       nid_front: '',
       nid_back: '',
});



const Options = [
       { value: 1, label: '১ বছর' },
       { value: 2, label: '২ বছর' },
       { value: 3, label: '৩ বছর' },
       { value: 4, label: '৪ বছর' },
       { value: 5, label: '৫ বছর' },
       { value: 6, label: '6+ বছর' },
       { value: 7, label: '7+ বছর' },
       { value: 8, label: '8+ বছর' },
]

const submit = () => {
       form.post(route('customer.store.profile'), {
              onSuccess: (response) => {

              },
              onError: (errors) => {
                     toast.error('অনুগ্রহ করে ফর্মের ভুলগুলো ঠিক করুন', {
                            position: 'bottom-right'
                     });
              },
       });
}


</script>



<template>
       <DefaultLayout>

              <Head title="প্রোফাইল তৈরী" />
              <div class="max-w-4xl mx-auto px-4">
                     <PageHeadline title="সেবা গ্রহণকারী হিসেবে আপনার প্রোফাইল" highlight="সম্পূর্ণ করুন"
                            description="আপনার প্রয়োজন অনুযায়ী কাজ পোস্ট করুন, সহজে সেবা নিন এবং অন্যদের সহায়তা করুন।" />
                     <ProgressBar />
                     <div class="bg-white rounded-lg shadow-md p-8">
                            <form id="taskerRegistrationForm" @submit.prevent="submit">
                                   <div class="mb-4">
                                          <h3 class="text-xl font-bold text-dark mb-6">ব্যক্তিগত তথ্য</h3>

                                          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                 <div>
                                                        <InputLabel for="name" value="পূর্ণ নাম" />
                                                        <TextInput type="text" class="w-full p-3"
                                                               placeholder="আপনার পূর্ণ নাম লিখুন" readonly="true" />
                                                 </div>
                                                 <div>
                                                        <InputLabel for="number" value="মোবাইল নম্বর" />
                                                        <TextInput class="w-full p-3"
                                                               placeholder="আপনার ফোন নম্বর লিখুন" readonly="true" />
                                                 </div>
                                                 <div>
                                                        <InputLabel for="email" value="ইমেইল" required />
                                                        <TextInput type="email" class="w-full p-3"
                                                               placeholder="আপনার ইমেইল লিখুন" readonly="true" />
                                                 </div>
                                                 <div>
                                                        <InputLabel for="nid_number" value="এনআইডি নম্বর" required />
                                                        <BaseNumberInput :error="form.errors.nid_number" type="number"
                                                               class="w-full p-3"
                                                               placeholder="জাতীয় পরিচয়পত্র নম্বর" />
                                                        <InputError class="mt-2" :message="form.errors.nid_number" />
                                                 </div>
                                          </div>
                                   </div>
                                   <div class="mb-4">
                                          <h3 class="text-xl font-bold text-dark mb-6">লোকেশন তথ্য</h3>
                                          <LocationSelector :districts="districts" :zilas="zilas"
                                                 v-model:districtId="form.district_id" v-model:zilaId="form.zila_id"
                                                 v-model:upozilaId="form.upozila_id" :errors="form.errors" />
                                   </div>
                                   <div class="mb-8">
                                          <h3 class="text-xl font-bold text-dark mb-6">আপনার কি ধরনের দক্ষতা ও সেবা</h3>
                                          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                                 <div>
                                                        <InputLabel for="skils" value="দক্ষাতা" required />
                                                        <TagsInput :errors="form.errors"
                                                               placeholder="আপনি কি কাজে দক্ষ ?" />
                                                        <InputError class="mt-2" :message="form.errors.skills" />
                                                 </div>
                                                 <div>
                                                        <InputLabel for="experience" value="অবিজ্ঞতা" required />
                                                        <SelectInput :errors="form.errors" :options="Options"
                                                               class="w-full p-3" defaultVal="এই কাজে কত বছরের অবিজ্ঞ্য"
                                                               labelKey="label" valueKey="value" />
                                                        <InputError class="mt-2" :message="form.errors.experience" />
                                                 </div>
                                          </div>

                                   </div>
                                   <div class="mb-4">
                                          <h3 class="text-xl font-bold text-dark mb-6">ডকুমেন্ট আপলোড</h3>
                                          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                 <div>
                                                        <InputLabel for="document" value="এনআইডি ফ্রন্ট সাইড"
                                                               required />
                                                        <Upolad :errors="form.errors"
                                                               acceptedType=".jpg,.jpeg,.png,.gif,.svg,.pdf" />
                                                        <InputError class="mt-2" :message="form.errors.nid_front" />
                                                 </div>
                                                 <div>
                                                        <InputLabel for="document" value="এনআইডি ব্যাক সাইড" required />
                                                        <Upolad :errors="form.errors"
                                                               acceptedType=".jpg,.jpeg,.png,.gif,.svg,.pdf" />
                                                        <InputError class="mt-2" :message="form.errors.nid_back" />
                                                 </div>
                                          </div>
                                   </div>
                                   <PrimaryButton type="submit"
                                          class="w-full bg-primary text-white py-3 rounded-lg hover:bg-blue-700 font-medium text-lg">
                                          রেজিস্টার সম্পন্ন করুন
                                   </PrimaryButton>
                            </form>
                     </div>
                     <Benefits />
              </div>

       </DefaultLayout>
</template>