<script setup>
import TaskerAuthenticatedLayout from '@/Layouts/TaskerAuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PendingBids from './Partials/PendingBids.vue';

const props = defineProps({
    pendingBids: {
        type: Array,
        default: () => []
    },
    acceptedBids: {
        type: Array,
        default: () => []
    },
    rejectedBids: {
        type: Array,
        default: () => []
    },
})

</script>

<template>
    <TaskerAuthenticatedLayout>
        <Head title="আপনার কাজ"/>
        <div class="lg:col-span-3">
           <PendingBids 
           :pending="pendingBids" 
           :accepted="acceptedBids" 
           :rejected="rejectedBids" 
           /> 
        </div>
    </TaskerAuthenticatedLayout>
</template>