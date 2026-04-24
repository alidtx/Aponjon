<script setup>
import TaskerDefaultLayout from '@/Layouts/TaskerDefaultLayout.vue';
import { Head } from '@inertiajs/vue3';
import PendingBids from './Partials/PendingBids.vue';

</script>

<template>
    <TaskerDefaultLayout>
        <Head title="আপনার কাজ"/>
        <div class="lg:col-span-3">
           <PendingBids /> 
        </div>
    </TaskerDefaultLayout>
</template>