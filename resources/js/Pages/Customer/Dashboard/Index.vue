<script setup>
import { Head } from '@inertiajs/vue3'
import CustomerAuthenticatedLayout from '@/Layouts/CustomerAuthenticatedLayout.vue';
import Overview from './Partials/Overview.vue';

const props = defineProps({
    overview: {
        type: Object,
        default: () => ({})
    },
    activity: {
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
    monthlyErning: {
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
             :activeBids="props.overview?.data?.bids" :monthly="monthlyErning" :recentActivity="activity"
             :inProgress="props.inProgress" :inBiding="props.inBiding" />
        </div>
    </CustomerAuthenticatedLayout>
</template>