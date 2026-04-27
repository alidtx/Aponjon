<script setup>
import { Head } from '@inertiajs/vue3'
import CustomerAuthenticatedLayout from '@/Layouts/CustomerAuthenticatedLayout.vue';
import Overview from './Partials/Overview.vue';
import { ref, computed } from 'vue'


</script>

<template>
    <CustomerAuthenticatedLayout>
        <Head title="হোম" />
       <div class="lg:col-span-3">
            <!-- <Overview :activeBids="props.overview?.data?.bids" :monthly="monthlyErning" :recentActivity="activity" /> -->
        </div>
    </CustomerAuthenticatedLayout>
</template>