<script setup>
import MarketplaceDefaultLayout from '@/Layouts/MarketplaceDefaultLayout.vue';
import { Head } from '@inertiajs/vue3';
import BreadCrumb from './Partials/BreadCrumb.vue';
import TaskDetail from './Partials/TaskDetail.vue';
import SideBar from './Partials/SideBar.vue';
import RelatedTask from './Partials/RelatedTask.vue';
import { computed } from 'vue';

const props = defineProps({
    taskDetails: {
        type: Object,
        required: true
    },
    totalTaskCount: {
        type: Number,
        default:0
    },
})

const budget = computed(() => props.taskDetails.data?.budget)
const customerTask = computed(() => props.taskDetails.data?.customer?.customer_tasks)


</script>


<template>
   <MarketplaceDefaultLayout>
    <Head title="টাস্কের বিস্তারিত"/>
    <main class="max-w-7xl mx-auto px-4 py-8">
        <BreadCrumb/>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
           <TaskDetail
           :details="props.taskDetails"
           />
           <SideBar
           :bids="props.taskDetails.data?.bid"
           :budget="budget"
           :totalTaskCount="totalTaskCount"
           :customerTask="customerTask"
           />
        </div>
    </main>
    <RelatedTask/>
   </MarketplaceDefaultLayout>
</template>