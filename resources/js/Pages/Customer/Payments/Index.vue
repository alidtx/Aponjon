<script setup>
import CustomerAuthenticatedLayout from '@/Layouts/CustomerAuthenticatedLayout.vue';
import DataTable from '@/Components/DataTable/Index.vue'
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import PayableBidDetails from './Partials/PayableBidDetails.vue';

const props = defineProps({
    payableBids: {
        type: Object,
        default: () => ({ data: [], links: {}, meta: {} })
    }
})

const tableHeader = ref([
    { name: 'নাম', data: 'tasker.name', orderable: true, contentType: 'text' },
    { name: 'কাজের নাম', data: 'task.title', orderable: true, contentType: 'text' },
    { name: 'কাজের নম্বর', data: 'task.task_number', orderable: true, contentType: 'text' },
    { name: 'সেটেল আমাউন্ট', data: 'amount', orderable: true, contentType: 'text' },
    { name: 'অ্যাকশন', data: 'action', orderable: false, contentType: 'slots', slotsName: 'actions' }
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

const loadMoreData = () => {

    console.log('Loading more data...')
}

const payableBids = computed(() => props.payableBids?.data || [])
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
                    :tableData="payableBids"
                    @rowClicked="handleRowClick" 
                    @getFilteredResults="loadMoreData"
                >
            <template #actions="{ rowData }">

                        <Link :href="route('customer.gigs.edit', rowData.id)" @click.stop
                            class="inline-flex items-center px-3 py-1 mr-2 text-sm font-medium text-blue-700 bg-blue-100 rounded-md hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                          পেয়মেন্ট করুন
                        </Link>
                    </template>
            </DataTable>
            </div>
        </div>  
        <Modal :show="isOpenModel" @close="closeModal">
            <div class="p-6 space-y-3" v-if="selectedTask">
                <PayableBidDetails :payableBids="payableBids" />
                <div class="flex justify-end pt-4">
                    <button @click="closeModal" class="px-4 py-2 bg-gray-200 rounded-lg">
                        Close
                    </button>
                </div>
            </div>
        </Modal>
    </CustomerAuthenticatedLayout>   
</template>