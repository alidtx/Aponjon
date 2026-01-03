<script setup>
import MarketplaceDefaultLayout from '@/Layouts/MarketplaceDefaultLayout.vue';
import PageHeadline from '@/Components/PageHeadline.vue';
import Stats from './Partials/Stats.vue';
import SideBar from './Partials/SideBar.vue';
import CardPortion from './Partials/CardPortion.vue';
import { Head } from '@inertiajs/vue3'
import { onMounted, ref } from 'vue'

const props = defineProps({
    totalTask: {
        type: Number,
        required: true
    },
    activeTasker: {
        type: Number,
        required: true
    },
    totalBudget: {
        type: [Number, String],
        required: true
    },
    completedTasks: {
        type: Number,
        required: true
    },

})
const cardData = ref([])
const isLoading = ref(true)

const FetchCardPortionData = async () => {
    const response = await axios.patch(
        route('fetch-task-data'),
    )
    console.log(response);
    cardData.value = response.data?.data
}

onMounted(() => {
    FetchCardPortionData();
})

</script>

<template>
    <MarketplaceDefaultLayout>
        <Head title="মার্কেট প্লেস" />
        <PageHeadline title="সেবার" highlight="অনুরোধসমূহ"
            description="বাংলাদেশের বিভিন্ন প্রান্ত থেকে আসা হাজারো সেবার অনুরোধ। আপনার দক্ষতা অনুযায়ী কাজ খুঁজে নিন।" />
        <Stats :totalTask="props.totalTask" :activeTasker="props.activeTasker" :totalBudget="props.totalBudget"
            :completedTasks="props.completedTasks" />
        <div class="flex flex-col lg:flex-row gap-8">
            <SideBar />
            <CardPortion :cardData="cardData" :loading="isLoading" />
        </div>
    </MarketplaceDefaultLayout>
</template>