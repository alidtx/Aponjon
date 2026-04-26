<script setup>
import UpdateUserSettingIcon from '@/Components/Icons/updateUserSettingIcon.vue';
import UserSettingsIcon from '@/Components/Icons/UserSettingsIcon.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
    phone: user.phone,
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

        <form
            @submit.prevent="form.patch(route('profile.update'))"
            class="mt-6 space-y-6"
        >
            <div>
                <InputLabel for="name" value="নাম" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="ইমেইল" />

                <TextInput
                    id="email"
                    type="email"
                    disabled
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <div>
                <InputLabel for="phone" value="ফোন নম্বর" />

                <TextInput
                    id="phone"
                    disabled
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.phone"
                    required
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">সংরক্ষণ করুন</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600"
                    >
                        সংরক্ষিত হয়েছে।
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>