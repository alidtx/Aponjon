<script setup>
import TaskerDefaultLayout from '@/Layouts/TaskerDefaultLayout.vue';
import { Head } from '@inertiajs/vue3'
import Overview from './Partials/Overview.vue';


const props = defineProps({
    overview: {
        type: Object,
        default: () => ({})
    },
    activity: {
        type: Object,
        default: () => ({})
    },
    monthlyErning: {
        type: Number,
        default: 0
    },
})

</script>


<template>
    <TaskerDefaultLayout>
        <Head title="টাস্কার ড্যাশবোর্ড" />
                <div class="lg:col-span-3">
                    <Overview 
                    :activeBids="props.overview?.data?.bids" 
                    :monthly="monthlyErning" 
                    :recentActivity="activity" 
                    />
                </div>
    </TaskerDefaultLayout>
</template>