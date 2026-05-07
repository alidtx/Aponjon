<script setup>
import CustomerAuthenticatedLayout from '@/Layouts/CustomerAuthenticatedLayout.vue';
import DataTable from '@/Components/DataTable/Index.vue'
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import BidDetails from './Partials/BidDetails.vue';

const props = defineProps({
    disputed: {
        type: Object,
        default: () => ({ data: [], links: {}, meta: {} })
    }
})

const tableHeader = ref([
    { name: 'নাম', data: 'tasker.name', orderable: true, contentType: 'text' },
    { name: 'কাজের নাম', data: 'task.title', orderable: true, contentType: 'text' },
    { name: 'কাজের নম্বর', data: 'task.task_number', orderable: true, contentType: 'text' },
    { name: 'বাজেট', data: 'amount', orderable: true, contentType: 'text' },
])

const hasMore = ref(true)
const page = ref(1)
const isLoading = ref(false)

const isOpenModel = ref(false)
const selectedTask = ref(null)

const handleRowClick = (row) => {
    selectedTask.value = row
    isOpenModel.value = true
}

const closeModal = () => {
    isOpenModel.value = false
    selectedTask.value = null
}

// If you have a load more function
const loadMoreData = () => {
    // Implement your data loading logic here
    console.log('Loading more data...')
}

// Computed property to safely access disputed data
const disputedData = computed(() => props.disputed?.data || [])
</script>

<template>
    <CustomerAuthenticatedLayout>
        <Head title="বিতর্কিত" />
        <div class="lg:col-span-3">
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex justify-between items-center py-3">
                    <h2 class="text-2xl font-bold text-dark">যে কাজগুলো বিতর্কিত হয়েছে</h2>
                </div>
                <DataTable 
                    :tableHeader="tableHeader" 
                    :tableData="disputedData"
                    @rowClicked="handleRowClick" 
                    @getFilteredResults="loadMoreData"
                />
            </div>
        </div>  
        <Modal :show="isOpenModel" @close="closeModal">
            <div class="p-6 space-y-3" v-if="selectedTask">
                <BidDetails :task="selectedTask" />
                <div class="flex justify-end pt-4">
                    <button @click="closeModal" class="px-4 py-2 bg-gray-200 rounded-lg">
                        Close
                    </button>
                </div>
            </div>
        </Modal>
    </CustomerAuthenticatedLayout>   
</template>