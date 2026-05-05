<script setup>
import CustomerAuthenticatedLayout from '@/Layouts/CustomerAuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import AppliedBidsStatus from './Partials/AppliedBidsStatus.vue';

</script>



<template>
      <CustomerAuthenticatedLayout>
         <Head title="বিড"/>
         <div class="lg:col-span-3">
           <AppliedBidsStatus
           />
        </div>
      </CustomerAuthenticatedLayout>
</template>