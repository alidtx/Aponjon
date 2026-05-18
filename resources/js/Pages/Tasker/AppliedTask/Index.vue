<script setup>
import TaskerAuthenticatedLayout from '@/Layouts/TaskerAuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import DataTable from '@/Components/DataTable/Index.vue';
import { computed, ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import AppliedTaskDetails from './Partials/AppliedTaskDetails.vue';

const props=defineProps({

      appliedTask:{
        type:Object,
        default: () => ({ data: [], links: {}, meta: {} })
      }
})



const tableHeader = ref([
    { name: 'কাজের নাম', data: 'task.title', orderable: true, contentType: 'text' },
    { name: 'কাজের নম্বর', data: 'task.task_number', orderable: true, contentType: 'text' },
    { name: 'বাজেট', data: 'task.budget', orderable: true, contentType: 'text' },
    { name: 'আপনার প্রপোজাল', data: 'amount', orderable: true, contentType: 'text' },
    { name: 'স্ট্যাটাস', data: 'status', orderable: true, contentType: 'text', isLabel: true },
    { name: 'অ্যাকশন', data: 'action', orderable: false, contentType: 'slots', slotsName: 'actions' }
])

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

const appliedTask = computed(() => props.appliedTask?.data || [])

</script>



<template>
    <TaskerAuthenticatedLayout>
        <Head title="অ্যাপ্লাইড কাজ" />
        <div class="lg:col-span-3">
          <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex justify-between items-center py-3">
                    <h2 class="text-2xl font-bold text-dark">আপনার আবেদনকৃত কাজগুলো</h2>
                </div>
                <DataTable :tableHeader="tableHeader" :tableData="appliedTask"
                    @rowClicked="handleRowClick" @getFilteredResults="loadMoreData" @updateColumns="handleColumnUpdate">
                    <template #actions="{ rowData }">

                        <Link :href="route('customer.gigs.edit', rowData.id)" @click.stop
                            class="inline-flex items-center px-3 py-1 mr-2 text-sm font-medium text-blue-700 bg-blue-100 rounded-md hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                            এডিট
                        </Link>

                        <button @click.stop="confirmDelete(rowData.id)"
                            class="inline-flex items-center px-3 py-1 text-sm font-medium text-red-700 bg-red-100 rounded-md hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors duration-200">

                            ডিলেট
                        </button>
                    </template>
                </DataTable>
          </div>
        </div>  
        <Modal :show="isOpenModel" @close="closeModal">
             <div class="p-6 space-y-3" v-if="selectedTask">
                <AppliedTaskDetails :appliedTask="selectedTask" />
                <div class="flex justify-end pt-4">
                    <button @click="closeModal" class="px-4 py-2 bg-gray-200 rounded-lg">
                        Close
                    </button>
                </div>
            </div>
        </Modal>
     </TaskerAuthenticatedLayout>   
</template>