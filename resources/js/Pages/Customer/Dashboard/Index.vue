<script setup>
import { Head } from '@inertiajs/vue3'
import CustomerAuthenticatedLayout from '@/Layouts/CustomerAuthenticatedLayout.vue';
import Overview from './Partials/Overview.vue';

const props = defineProps({
    overview: {
        type: Object,
        default: () => ({})
    },
    inProgress: {
        type: Number,
        default: 0
    },
     inBiding: {
        type: Number,
        default: 0
    },
    pendingActivity: {
        type: Object,
        default: () => ({})
    },
    acceptedActivity: {
        type: Object,
        default: () => ({})
    },
    monthlySpend: {
        type: Number,
        default: 0
    },
})

</script>

<template>
    <CustomerAuthenticatedLayout>
        <Head title="হোম" />
       <div class="lg:col-span-3">
            <Overview 
             :activeBids="props.overview?.data?.bids" 
             :monthly="monthlySpend" 
             :inProgress="props.inProgress" 
             :inBiding="props.inBiding" 
             :pendingActivity="props.pendingActivity" 
             :acceptedActivity="props.acceptedActivity" 
             />
        </div>
    </CustomerAuthenticatedLayout>
</template>