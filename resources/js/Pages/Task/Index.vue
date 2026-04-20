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
    totalEarning: {
        type: Number,
        default: 0
    },
    monthlyErning: {
        type: Number,
        default: 0
    },
    successRate: {
        type: Number,
        default: 0
    }
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
                :total="totalEarning" 
                :successRate="successRate" 
                />
                <div class="lg:col-span-3">
                    <Overview 
                    :activeBids="props.overview?.data?.bids" 
                    :monthly="monthlyErning" 
                    />
                    <AssignedTask />
                </div>
            </div>
        </div>
    </TaskerDefaultLayout>
</template>