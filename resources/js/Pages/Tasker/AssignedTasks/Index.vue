<script setup>
import TaskerAuthenticatedLayout from '@/Layouts/TaskerAuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import AssignedBids from './Partials/AssignedBids.vue';

const props = defineProps({
    inProgressTasks: {
        type: Array,
        default: () => []
    },
    assignedTasks: {
        type: Array,
        default: () => []
    },
    completedTasks: {
        type: Array,
        default: () => []
    },
    disputedTasks: {
        type: Array,
        default: () => []
    },
});

</script>

<template>
    <TaskerAuthenticatedLayout>
        <Head title="অ্যাসাইনড টাস্কস"/>
        <div class="lg:col-span-3">
            <AssignedBids 
                :in-progress-tasks="inProgressTasks"
                :assigned-tasks="assignedTasks"
                :completed-tasks="completedTasks"
                :disputed-tasks="disputedTasks"
            /> 
        </div>
    </TaskerAuthenticatedLayout>
</template>