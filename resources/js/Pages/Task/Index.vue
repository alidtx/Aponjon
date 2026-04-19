<script setup>
import TaskerDefaultLayout from '@/Layouts/TaskerDefaultLayout.vue';
import { Head } from '@inertiajs/vue3'
import SideBar from './Partials/SideBar.vue';
import Overview from './Partials/Overview.vue';
import AssignedTask from './Partials/AssignedTask.vue';
import { computed } from 'vue';


const props = defineProps({
    overview: {
        type: Object,
        default: () => ({})
    },
})

</script>


<template>
    <TaskerDefaultLayout>

        <Head title="টাস্কার ড্যাশবোর্ড" />
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <SideBar 
                :tasker="props.overview?.data?.name"
                :tasker_profile="props.overview?.data?.tasker_profile"
                />
                <div class="lg:col-span-3">
                    <Overview 
                    :activeBids="props.overview?.data?.bids"
                    />
                    <AssignedTask />
                </div>
            </div>
        </div>
    </TaskerDefaultLayout>
</template>