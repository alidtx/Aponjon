<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('tasker.delete.tasker.account'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                অ্যাকাউন্ট মুছে ফেলুন
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                আপনার অ্যাকাউন্ট মুছে ফেলার পরে, এর সমস্ত তথ্য এবং ডেটা স্থায়ীভাবে মুছে ফেলা হবে।
                অ্যাকাউন্ট মুছে ফেলার আগে, আপনি যে কোনো ডেটা বা তথ্য সংরক্ষণ করতে চান তা ডাউনলোড করুন।
            </p>
        </header>

        <DangerButton @click="confirmUserDeletion">অ্যাকাউন্ট মুছে ফেলুন</DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2
                    class="text-lg font-medium text-gray-900"
                >
                    আপনি কি নিশ্চিত যে আপনার অ্যাকাউন্ট মুছে ফেলতে চান?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    আপনার অ্যাকাউন্ট মুছে ফেলার পরে, এর সমস্ত তথ্য এবং ডেটা স্থায়ীভাবে মুছে ফেলা হবে।
                    অনুগ্রহ করে আপনার পাসওয়ার্ড লিখুন নিশ্চিত করার জন্য যে আপনি আপনার অ্যাকাউন্ট স্থায়ীভাবে মুছে ফেলতে চান।
                </p>

                <div class="mt-6">
                    <InputLabel
                        for="password"
                        value="পাসওয়ার্ড"
                        class="sr-only"
                    />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-3/4"
                        placeholder="আপনার পাসওয়ার্ড লিখুন"
                        @keyup.enter="deleteUser"
                    />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        বাতিল করুন
                    </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        অ্যাকাউন্ট মুছে ফেলুন
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>