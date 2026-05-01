<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import { TailwindPagination } from 'laravel-vue-pagination'
import CustomerAuthenticatedLayout from '@/Layouts/CustomerAuthenticatedLayout.vue'
import DataTable from '@/Components/DataTable/Index.vue'
import { ref } from 'vue'

const props= defineProps({
    customerTasks:{
        type:Object,
         default: () => ({})
    }

})

console.log()

const hasMore = ref(true)
const page = ref(1)
const isLoading = ref(false)
const handleRowClick = (row) => {
    console.log('Row clicked:', row)
    alert(`Selected: ${row.name} (${row.email})`)
}

const editUser = (id) => {
    const user = userData.value.find(u => u.id === id)
    console.log('Edit user:', id, user)
    alert(`Edit user: ${user?.name}`)
}

const loadMoreData = async (params, loadMore = false) => {
    if (isLoading.value) return

    isLoading.value = true
    await new Promise(resolve => setTimeout(resolve, 1000))

    if (loadMore && page.value < 3) {
        page.value++
        const moreUsers = [
            {
                id: 11,
                name: 'Kevin White',
                email: 'kevin.w@example.com',
                role: 'User',
                status: 'Active',
                joinDate: '2024-03-15'
            },
            {
                id: 12,
                name: 'Amanda Lee',
                email: 'amanda.l@example.com',
                role: 'Editor',
                status: 'Active',
                joinDate: '2024-03-18'
            }
        ]

        userData.value.push(...moreUsers)

        if (page.value >= 3) {
            hasMore.value = false
        }
    }

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

const perPage = ref(props.customerTasks.data?.per_page ?? 5)
const getFilteredResults = (page = 1) => {
    isLoading.value = true
    router.visit(route('customer.gig'), {
        data: {
            page: page,
            per_page: parseInt(perPage.value),
        },
        preserveScroll: true,
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
            <div id="createGig" class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex justify-between items-center py-3">
                    <h2 class="text-2xl font-bold text-dark ">আপনার কাজ গুলোর লিস্ট</h2>
                    <Link :href="route('customer.create.gig')" class="px-4 py-1 bg-primary text-white rounded-lg">
                        নতুন কাজ তৈরি করুন
                    </Link>
                </div>
                <DataTable :tableHeader="tableHeader" :tableData="props.customerTasks?.data" :hasMorePages="hasMore" :currentPage="page"
                    @rowClicked="handleRowClick" @getFilteredResults="loadMoreData" @updateColumns="handleColumnUpdate">
                    <template #actions="{ rowData }">
                        <div class="flex items-center gap-2">
                            <button @click="editUser(rowData.id)"
                                class="rounded-md bg-brand-primary-surface-subtle px-3 py-1 text-sm font-medium text-brand-primary-text-subtle transition-colors hover:bg-brand-primary-surface-default hover:text-white">
                                Edit
                            </button>
                        </div>
                    </template>
                </DataTable>
            <div class="flex justify-center items-center space-x-2 mt-8">
             <TailwindPagination :data="props.customerTasks" @pagination-change-page="getFilteredResults" :limit="1"
                class="mx-5" />
            </div>
            </div>
        </div>
    </CustomerAuthenticatedLayout>
</template>

<style scoped>
/* Add any custom styles here */
</style>