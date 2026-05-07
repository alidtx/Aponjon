<script setup>
import CustomerAuthenticatedLayout from '@/Layouts/CustomerAuthenticatedLayout.vue';
import DataTable from '@/Components/DataTable/Index.vue'
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';


const tableHeader = ref([
    { name: 'কাজের নাম', data: 'title', orderable: true, contentType: 'text' },
    { name: 'কাজের নম্বর', data: 'task_number', orderable: true, contentType: 'text' },
    { name: 'বাজেট', data: 'budget', orderable: true, contentType: 'text' },
    { name: 'স্ট্যাটাস', data: 'status', orderable: true, contentType: 'text', isLabel: true },
    { name: 'অ্যাকশন', data: 'action', orderable: false, contentType: 'slots', slotsName: 'actions' }
])


</script>



<template>
    <CustomerAuthenticatedLayout>
        <Head title="বিতর্কিত" />
        <div class="lg:col-span-3">
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex justify-between items-center py-3">
                    <h2 class="text-2xl font-bold text-dark">যে কাজগুলো বিতর্কিত হয়েছে </h2></div>
                    <DataTable :tableHeader="tableHeader"
                    @rowClicked="handleRowClick" @getFilteredResults="loadMoreData">
                        
                    </DataTable>        
          </div>

        </div>  
     </CustomerAuthenticatedLayout>   
</template>