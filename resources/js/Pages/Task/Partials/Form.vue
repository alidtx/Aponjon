<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import BaseNumberInput from '@/Components/BaseNumberInput.vue';
import LocationSelector from '@/Components/LocationSelector.vue';
import SelectInput from '@/Components/SelectInput.vue';
import Upolad from '@/Components/Upolad.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextArea from '@/Components/TextArea.vue';
import TagsInput from '@/Components/TagsInput.vue';
import { toast } from 'vue3-toastify';
import UpdateIcon from '@/Components/Icons/UpdateIcon.vue';

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
});

const taskerProfile = props.loggedInUser?.data?.tasker_profile || {};
const sliderValue = ref(taskerProfile.hourly_rate || 250);

const form = useForm({
    nid_number: taskerProfile.nid_number || '',
    skills: taskerProfile.skills || '',
    experience: taskerProfile.experience || '',
    district_id: taskerProfile.district_id || '',
    zila_id: taskerProfile.zila_id || '',
    upozila_id: taskerProfile.upozila_id || '',
    bio: taskerProfile.bio || '',
    hourly_rate: sliderValue.value,
    nid_front: taskerProfile.nid_front || '',
    nid_back: taskerProfile.nid_back || '',
    person_image: props.loggedInUser?.data?.profile_photo || '',
});

watch(sliderValue, (newValue) => {
    form.hourly_rate = newValue;
});

const placeholder = `৮ বছরের অভিজ্ঞতা নিয়ে আমি একজন প্রফেশনাল ইলেকট্রিশিয়ান। বাসা-বাড়ি, অফিস, দোকান - সকল ধরনের ইলেকট্রিক্যাল কাজে আমি পারদর্শী। আমি শুধু মেরামতই নয়, নতুন ওয়্যারিং,ইলেকট্রিক্যাল ডিজাইন এবং এনার্জি এফিসিয়েন্ট সলিউশনও প্রদান করি।`;

const Options = [
    { value: 1, label: '১ বছর' },
    { value: 2, label: '২ বছর' },
    { value: 3, label: '৩ বছর' },
    { value: 4, label: '৪ বছর' },
    { value: 5, label: '৫ বছর' },
    { value: 6, label: '6+ বছর' },
    { value: 7, label: '7+ বছর' },
    { value: 8, label: '8+ বছর' },
];

const submit = () => {
    const submitData = {
        ...form.data(),
        hourly_rate: sliderValue.value
    };
    
    form.post(route('tasker.profile.update', props.loggedInUser.data.id), {
        data: submitData,
        onSuccess: (response) => {
            toast.success('প্রোফাইল সফলভাবে আপডেট করা হয়েছে', {
                position: 'bottom-right'
            });
        },
        onError: (errors) => {
            toast.error('অনুগ্রহ করে ফর্মের ভুলগুলো ঠিক করুন', {
                position: 'bottom-right'
            });
        },
    });
};
</script>

<template>
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow-md p-8">
            <div class="mb-6 pb-4 border-b">
                <div class="flex items-center gap-2 mb-2">
                    <UpdateIcon />
                    <h1 class="text-2xl font-bold text-dark">প্রোফাইল সম্পাদনা করুন</h1>
                </div>
                <p class="text-gray-600 ml-9">আপনার তথ্য আপডেট করুন</p>
            </div>
            
            <form id="taskerRegistrationForm" @submit.prevent="submit">
                <div class="mb-4">
                    <h3 class="text-xl font-bold text-dark mb-6">ব্যক্তিগত তথ্য</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <InputLabel for="name" value="পূর্ণ নাম" />
                            <TextInput 
                                type="text" 
                                :model-value="props.loggedInUser?.data?.name || ''" 
                                class="w-full p-3 bg-gray-50"
                                placeholder="আপনার পূর্ণ নাম লিখুন" 
                                readonly="true" 
                            />
                        </div>
                        <div>
                            <InputLabel for="number" value="মোবাইল নম্বর" />
                            <TextInput 
                                :model-value="props.loggedInUser?.data?.phone || ''" 
                                class="w-full p-3 bg-gray-50"
                                placeholder="আপনার ফোন নম্বর লিখুন" 
                                readonly="true" 
                            />
                        </div>
                        <div>
                            <InputLabel for="email" value="ইমেইল" required />
                            <TextInput 
                                :model-value="props.loggedInUser?.data?.email || ''" 
                                type="email" 
                                class="w-full p-3 bg-gray-50"
                                placeholder="আপনার ইমেইল লিখুন" 
                                readonly="true" 
                            />
                        </div>
                        <div>
                            <InputLabel for="nid_number" value="এনআইডি নম্বর" required />
                            <BaseNumberInput 
                                v-model="form.nid_number" 
                                :error="form.errors.nid_number" 
                                type="text"
                                class="w-full p-3" 
                                placeholder="জাতীয় পরিচয়পত্র নম্বর" 
                            />
                            <InputError class="mt-2" :message="form.errors.nid_number" />
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <InputLabel for="about" value="আপনার সম্পর্কে লিখুন" required />
                    <TextArea 
                        class="w-full p-3" 
                        :placeholder="placeholder" 
                        v-model="form.bio"
                        :error="form.errors.bio" 
                    />
                    <InputError class="mt-2" :message="form.errors.bio" />
                </div>
                
                <div class="mb-4">
                    <h3 class="text-xl font-bold text-dark mb-6">লোকেশন তথ্য</h3>
                    <LocationSelector 
                        :districts="districts" 
                        :zilas="zilas" 
                        v-model:districtId="form.district_id"
                        v-model:zilaId="form.zila_id" 
                        v-model:upozilaId="form.upozila_id" 
                        :errors="form.errors" 
                    />
                </div>
                
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-dark mb-6">আপনার দক্ষতা ও সেবা</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <InputLabel for="skills" value="দক্ষতা" required />
                            <TagsInput 
                                v-model="form.skills" 
                                :errors="form.errors"
                                placeholder="আপনি কি কাজে দক্ষ ?" 
                            />
                            <InputError class="mt-2" :message="form.errors.skills" />
                        </div>
                        <div>
                            <InputLabel for="experience" value="অভিজ্ঞতা" required />
                            <SelectInput 
                                v-model="form.experience" 
                                :errors="form.errors" 
                                :options="Options"
                                class="w-full p-3" 
                                defaultVal="এই কাজে কত বছরের অভিজ্ঞতা" 
                                labelKey="label"
                                valueKey="value" 
                            />
                            <InputError class="mt-2" :message="form.errors.experience" />
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-dark font-medium mb-2">আপনার ঘণ্টাপ্রতি রেট (৳)</label>
                        <div class="flex items-center">
                            <input 
                                type="range" 
                                min="100" 
                                max="2000" 
                                step="50" 
                                class="flex-1"
                                v-model="sliderValue"
                            >
                            <span class="ml-4 text-lg font-bold text-primary">৳<span>{{ sliderValue }}</span></span>
                        </div>
                        <InputError class="mt-2" :message="form.errors.hourly_rate" />
                    </div>
                </div>
                
                <div class="mb-4">
                    <h3 class="text-xl font-bold text-dark mb-3">ডকুমেন্ট আপলোড</h3>
                    <div class="mb-4">
                        <InputLabel for="person_image" value="আপনার নিজ ছবি" required />
                        <Upolad 
                            v-model="form.person_image" 
                            :errors="form.errors"
                            helperText="JPG, JPEG, PNG (সর্বোচ্চ ২MB)" 
                            acceptedType=".jpg,.jpeg,.png" 
                        />
                        <InputError class="mt-2" :message="form.errors.person_image" />
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <InputLabel for="nid_front" value="এনআইডি ফ্রন্ট সাইড" required />
                            <Upolad 
                                v-model="form.nid_front" 
                                :errors="form.errors"
                                acceptedType=".jpg,.jpeg,.png,.gif,.svg,.pdf" 
                            />
                            <InputError class="mt-2" :message="form.errors.nid_front" />
                        </div>
                        <div>
                            <InputLabel for="nid_back" value="এনআইডি ব্যাক সাইড" required />
                            <Upolad 
                                v-model="form.nid_back" 
                                :errors="form.errors"
                                acceptedType=".jpg,.jpeg,.png,.gif,.svg,.pdf" 
                            />
                            <InputError class="mt-2" :message="form.errors.nid_back" />
                        </div>
                    </div>
                </div>
                
                <PrimaryButton 
                    type="submit"
                    :disabled="form.processing"
                    class="w-full bg-primary text-white py-3 rounded-lg hover:bg-blue-700 font-medium text-lg"
                >
                    {{ form.processing ? 'আপডেট হচ্ছে...' : 'এডিট সম্পন্ন করুন' }}
                </PrimaryButton>
            </form>
        </div>
    </div>
</template>