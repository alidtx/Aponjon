<script setup>
import { Head, useForm, router } from '@inertiajs/vue3'
import CustomerAuthenticatedLayout from '@/Layouts/CustomerAuthenticatedLayout.vue'
import DataTable from '@/Components/DataTable/Index.vue'
import { ref } from 'vue'

const userData = ref([
    {
        id: 1,
        name: 'John Doe',
        email: 'john.doe@example.com',
        role: 'Admin',
        status: 'Active',
        joinDate: '2024-01-15'
    },
    {
        id: 2,
        name: 'Jane Smith',
        email: 'jane.smith@example.com',
        role: 'User',
        status: 'Active',
        joinDate: '2024-02-20'
    },
    {
        id: 3,
        name: 'Michael Johnson',
        email: 'michael.j@example.com',
        role: 'Editor',
        status: 'Inactive',
        joinDate: '2024-01-10'
    },
    {
        id: 4,
        name: 'Emily Brown',
        email: 'emily.brown@example.com',
        role: 'User',
        status: 'Active',
        joinDate: '2024-03-05'
    },
    {
        id: 5,
        name: 'David Wilson',
        email: 'david.wilson@example.com',
        role: 'Admin',
        status: 'Suspended',
        joinDate: '2023-12-01'
    },
    {
        id: 6,
        name: 'Sarah Martinez',
        email: 'sarah.m@example.com',
        role: 'Editor',
        status: 'Active',
        joinDate: '2024-02-14'
    },
    {
        id: 7,
        name: 'Robert Taylor',
        email: 'robert.t@example.com',
        role: 'User',
        status: 'Inactive',
        joinDate: '2024-01-28'
    },
    {
        id: 8,
        name: 'Lisa Anderson',
        email: 'lisa.a@example.com',
        role: 'Admin',
        status: 'Active',
        joinDate: '2024-03-10'
    },
    {
        id: 9,
        name: 'James Thomas',
        email: 'james.t@example.com',
        role: 'User',
        status: 'Active',
        joinDate: '2024-02-01'
    },
    {
        id: 10,
        name: 'Maria Garcia',
        email: 'maria.g@example.com',
        role: 'Editor',
        status: 'Suspended',
        joinDate: '2023-11-15'
    }
])

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
    { name: 'ID', data: 'id', orderable: true, contentType: 'text' },
    { name: 'Name', data: 'name', orderable: true, contentType: 'text' },
    { name: 'Email', data: 'email', orderable: true, contentType: 'text' },
    { name: 'Role', data: 'role', orderable: true, contentType: 'text' },
    { name: 'Status', data: 'status', orderable: true, contentType: 'text', isLabel: true },
    { name: 'Join Date', data: 'joinDate', orderable: true, contentType: 'text' },
    { name: 'Actions', data: 'id', orderable: false, contentType: 'slots', slotsName: 'actions' }
])
</script>

<template>
    <CustomerAuthenticatedLayout>
        <Head title="গিগ তৈরি" />
        <div class="lg:col-span-3">
                <DataTable
                    :tableHeader="tableHeader"
                    :tableData="userData"
                    :hasMorePages="hasMore"
                    :currentPage="page"
                    @rowClicked="handleRowClick"
                    @getFilteredResults="loadMoreData"
                    @updateColumns="handleColumnUpdate"
                >
                    <template #actions="{ rowData }">
                        <div class="flex items-center gap-2">
                            <button 
                                @click="editUser(rowData.id)"
                                class="rounded-md bg-brand-primary-surface-subtle px-3 py-1 text-sm font-medium text-brand-primary-text-subtle transition-colors hover:bg-brand-primary-surface-default hover:text-white"
                            >
                                Edit
                            </button>
                        </div>
                    </template>
                </DataTable>
        </div>        
    </CustomerAuthenticatedLayout>
</template>

<style scoped>
/* Add any custom styles here */
</style>