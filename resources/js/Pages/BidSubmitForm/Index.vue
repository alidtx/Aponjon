<script setup>
import MarketplaceDefaultLayout from '@/Layouts/MarketplaceDefaultLayout.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import DraftControls from '@/Components/DraftControls.vue';
import BidForm from './Partials/BidForm.vue';
import SideBar from './Partials/SideBar.vue';
import { Head } from '@inertiajs/vue3';


const props=defineProps({
   bidDetails:{
    type:Object,
    required:true
   }
})


</script>


<template>
    <MarketplaceDefaultLayout>

        <Head title="কাজ জমা" />
        <div class="max-w-6xl mx-auto mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <Breadcrumb />
                <DraftControls />
            </div>
        </div>
        <main class="max-w-7xl mx-auto px-4 py-8">
            <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6 grid-responsive">
               <BidForm
               :bidDetails="props.bidDetails"
                />
               <SideBar/>
            </div>
        </main>

    </MarketplaceDefaultLayout>
</template>