<script setup>
import TaskerDefaultLayout from '@/Layouts/TaskerDefaultLayout.vue';
import { Head } from '@inertiajs/vue3';
import AssignedTask from './Partials/AssignedTask.vue';

</script>

<template>
    <TaskerDefaultLayout>
        <Head title="আপনার কাজ"/>
        <div class="lg:col-span-3">
           <AssignedTask /> 
        </div>
    </TaskerDefaultLayout>
</template>