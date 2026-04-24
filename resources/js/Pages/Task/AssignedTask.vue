<script setup>
import TaskerDefaultLayout from '@/Layouts/TaskerDefaultLayout.vue';
import { Head } from '@inertiajs/vue3';
import AssignedBids from './Partials/AssignedBids.vue';

</script>

<template>
    <TaskerDefaultLayout>
        <Head title="অ্যাসাইনড টাস্কস"/>
        <div class="lg:col-span-3">
           <AssignedBids /> 
        </div>
    </TaskerDefaultLayout>
</template>