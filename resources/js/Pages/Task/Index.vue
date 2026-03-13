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

const form = useForm({
    district_id: '',
    zila_id: '',
    upozila_id: '',
});


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

</script>



<template>
    <DefaultLayout>

        <Head title="টাস্কার" />
        <div class="max-w-4xl mx-auto px-4">
            <PageHeadline title="টাস্কার হিসেবে আপনার প্রফাইল" highlight="কমপ্লিট করুন"
                description="আপনার দক্ষতা ব্যবহার করে আয় করুন এবং মানুষকে সাহায্য করুন।" />
            <ProgressBar />
            <div class="bg-white rounded-lg shadow-md p-8">
                <form id="taskerRegistrationForm">
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-dark mb-6">ব্যক্তিগত তথ্য</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <InputLabel for="name" value="পূর্ণ নাম" required />
                                <TextInput id="name" type="text" class="w-full p-3"
                                    placeholder="আপনার পূর্ণ নাম লিখুন" />
                                <InputError class="mt-2" />
                            </div>
                            <div>
                                <InputLabel for="number" value="মোবাইল নম্বর" required />
                                <TextInput id="number" type="number" class="w-full p-3" placeholder="01XXXXXXXXX" />
                                <InputError class="mt-2" />
                            </div>
                            <div>
                                <InputLabel for="email" value="ইমেইল" required />
                                <TextInput id="email" type="email" class="w-full p-3" placeholder="your@email.com" />
                                <InputError class="mt-2" />
                            </div>
                            <div>
                                <InputLabel for="email" value="এনআইডি নম্বর" required />
                                <BaseNumberInput id="nid" type="number" class="w-full p-3"
                                    placeholder="জাতীয় পরিচয়পত্র নম্বর" />
                                <InputError class="mt-2" />
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-dark mb-6">লোকেশন তথ্য</h3>
                        <LocationSelector :districts="districts" :zilas="zilas" v-model:districtId="form.district_id"
                            v-model:zilaId="form.zila_id" v-model:upozilaId="form.upozila_id" :errors="form.errors" />
                    </div>
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-dark mb-6">আপনার দক্ষতা ও সেবা</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <InputLabel for="skils" value="দক্ষাতা" required />
                                <TextInput id="skils" type="text" class="w-full p-3"
                                    placeholder="আপনি কি কাজে দক্ষ ?" />
                                <InputError class="mt-2" />
                            </div>
                            <div>
                                <InputLabel for="experience" value="অবিজ্ঞতা" required />
                                <SelectInput :options="Options" class="w-full p-3"
                                    defaultVal="এই কাজে কত বছরের অবিজ্ঞ্য" labelKey="label" valueKey="value" />
                                <InputError class="mt-2" />
                            </div>
                        </div>
                        <div class="mb-6">
                            <label class="block text-dark font-medium mb-2">আপনার ঘণ্টাপ্রতি রেট (৳)</label>
                            <div class="flex items-center">
                                <input type="range" min="100" max="2000" step="50" class="flex-1" v-model="sliderValue"
                                    @input="rangeValue">
                                <span class="ml-4 text-lg font-bold text-primary">৳<span id="rateValue">{{ sliderValue
                                }}</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-dark mb-6">ডকুমেন্ট আপলোড</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <InputLabel for="document" value="এনআইডি ফ্রন্ট সাইড" required />
                                <Upolad
                                 acceptedType=".jpg,.jpeg,.png,.gif,.svg,.pdf"
                                />
                            </div>
                            <div>
                                <InputLabel for="document" value="এনআইডি ব্যাক সাইড" required />
                                <Upolad
                                 acceptedType=".jpg,.jpeg,.png,.gif,.svg,.pdf"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <div class="flex items-start">
                            <input type="checkbox" class="w-5 h-5 text-primary rounded mt-1" required>
                            <label class="ml-3 text-gray-700">
                                আমি <a href="#" class="text-primary hover:underline">টার্মস অ্যান্ড কন্ডিশন</a> এবং <a
                                    href="#" class="text-primary hover:underline">প্রাইভেসি পলিসি</a> পড়েছি এবং সম্মতি
                                দিচ্ছি
                            </label>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-primary text-white py-4 rounded-lg hover:bg-blue-700 font-medium text-lg">
                        রেজিস্টার সম্পন্ন করুন
                    </button>
                </form>
            </div>
            <Benefits />
        </div>
    </DefaultLayout>
</template>