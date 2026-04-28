<script setup>
import UpdateUserSettingIcon from '@/Components/Icons/updateUserSettingIcon.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
});
</script>

<template>
    <section>
        <div class="mb-6 pb-4 border-b">
            <div class="flex items-center gap-2 mb-2">
                <UpdateUserSettingIcon />
                <h1 class="text-2xl font-bold text-dark">সেটিংস পরিবর্তন করুন</h1>
            </div>
            <p class="text-gray-600 ml-9">আপনার তথ্য আপডেট করুন</p>
        </div>

        <form @submit.prevent="form.post(route('tasker.update.tasker.profile.settings'), {
            preserveScroll: true,

            onSuccess: (success) => {
                toast.success('প্রোফাইল সফলভাবে আপডেট করা হয়েছে', {
                    position: 'bottom-right'
                });
            },

            onError: (errors) => {
                toast.error('প্রোফাইল আপডেট করতে ব্যর্থ', {
                    position: 'bottom-right'
                });
            }
        })" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="নাম"  required/>

                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus
                    autocomplete="name" />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="ইমেইল" />

                <TextInput id="email" type="email" disabled class="mt-1 block w-full" v-model="user.email" 
                    autocomplete="username" />
            </div>
            <div>
                <InputLabel for="phone" value="ফোন নম্বর" />

                <TextInput id="phone" disabled type="text" class="mt-1 block w-full" v-model="user.phone" 
                    autocomplete="username" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">সংরক্ষণ করুন</PrimaryButton>          
            </div>
        </form>
    </section>
</template>