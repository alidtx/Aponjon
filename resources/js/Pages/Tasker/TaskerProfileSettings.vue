<script setup>
import TaskerAuthenticatedLayout from '@/Layouts/TaskerAuthenticatedLayout.vue';
import DeleteUserForm from './Partials/ProfileSettings/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/ProfileSettings/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/ProfileSettings/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';
</script>



<template>
    <TaskerAuthenticatedLayout>
        <Head title="ব্যবহারকারীর প্রোফাইল সেটিংস" />
        <div class="lg:col-span-3">
            <div class="max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                >
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                >
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                >
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        
        </div>  
     </TaskerAuthenticatedLayout>   
</template>