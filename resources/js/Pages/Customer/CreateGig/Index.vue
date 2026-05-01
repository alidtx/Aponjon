<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import { TailwindPagination } from 'laravel-vue-pagination'
import CustomerAuthenticatedLayout from '@/Layouts/CustomerAuthenticatedLayout.vue'
import DataTable from '@/Components/DataTable/Index.vue'
import { ref } from 'vue'
import Modal from '@/Components/Modal.vue'
import TaskDetail from '@/Pages/Bids/Partials/TaskDetail.vue'


const props = defineProps({
    customerTasks: {
        type: Object,
        default: () => ({ data: [], links: {}, meta: {} })
    }
})


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

const editUser = (id) => {
    const user = props.customerTasks?.data?.find(u => u.id === id)
    console.log('Edit:', id, user)
}

const loadMoreData = async () => {
    if (isLoading.value) return

    isLoading.value = true

    await new Promise(resolve => setTimeout(resolve, 500))

    isLoading.value = false
}


const handleColumnUpdate = (columns) => {
    console.log('Columns updated:', columns)
}

const tableHeader = ref([
    { name: 'কাজের নাম', data: 'title', orderable: true, contentType: 'text' },
    { name: 'কাজের নম্বর', data: 'task_number', orderable: true, contentType: 'text' },
    { name: 'বাজেট', data: 'budget', orderable: true, contentType: 'text' },
    { name: 'স্ট্যাটাস', data: 'status', orderable: true, contentType: 'text', isLabel: true },
    { name: 'অ্যাকশন', data: 'action', orderable: false, contentType: 'slots', slotsName: 'actions' }
])


const perPage = ref(5)

const getFilteredResults = (pageNumber = 1) => {
    isLoading.value = true

    router.get(route('customer.gig'), {
        page: pageNumber,
        per_page: perPage.value,
    }, {
        preserveScroll: true,
        preserveState: true,
        onFinish: () => {
            isLoading.value = false
        }
    })
}
</script>

<template>
    <CustomerAuthenticatedLayout>

        <Head title="গিগ তৈরি" />

        <div class="lg:col-span-3">
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">

                <!-- HEADER -->
                <div class="flex justify-between items-center py-3">
                    <h2 class="text-2xl font-bold text-dark">
                        আপনার কাজ গুলোর লিস্ট
                    </h2>

                    <Link :href="route('customer.create.gig')"
                        class="px-4 py-1 bg-primary text-white rounded-lg">
                        নতুন কাজ তৈরি করুন
                    </Link>
                </div>
                <DataTable
                    :tableHeader="tableHeader"
                    :tableData="props.customerTasks?.data"
                    @rowClicked="handleRowClick"
                    @getFilteredResults="loadMoreData"
                    @updateColumns="handleColumnUpdate"
                >
                    <template #actions="{ rowData }">
                        <button
                            @click="editUser(rowData.id)"
                            class="px-3 py-1 text-sm bg-gray-100 rounded"
                        >
                            Edit
                        </button>
                    </template>
                </DataTable>

                <div class="flex justify-center mt-8">
                    <TailwindPagination
                        :data="props.customerTasks"
                        @pagination-change-page="getFilteredResults"
                        :limit="1"
                    />
                </div>

            </div>
        </div>
        <Modal :show="isOpenModel" @close="closeModal">
            <div class="p-6 space-y-3" v-if="selectedTask">

                <TaskDetail 
                :task="selectedTask"
                />

                <div class="flex justify-end pt-4">
                    <button
                        @click="closeModal"
                        class="px-4 py-2 bg-gray-200 rounded-lg"
                    >
                        Close
                    </button>
                </div>

            </div>
        </Modal>

    </CustomerAuthenticatedLayout>
</template>