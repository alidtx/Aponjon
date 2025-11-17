<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    user: {
        type: Object,
        required: false,
        default:null
    }
})

const currentRoute = computed(() => usePage().url);
const isCreateGigPage = computed(() => currentRoute.value.includes('/customer/create-gig'));
</script>

<template>
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-2">
                        <Link :href="route('home')">
                            <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
                        </Link>
                </div>
                <div class="flex items-center space-x-4">
                    <template v-if="!isCreateGigPage">
                        <a href="marketplace.html" class="text-dark hover:text-primary">টাস্কস</a>
                        <Link :href="route('customer.create.gig')">
                            <span class="bg-accent text-white px-4 py-2 rounded-lg hover:bg-orange-600">
                                টাস্ক পোস্ট করুন
                            </span>
                        </Link>
                        <div class="relative group">
                            <button class="flex items-center space-x-2">
                                <span class="text-dark">{{ props.user?.data?.name }}</span>
                                <img :src="props.user?.data?.avatar" alt="User Avatar"
                                    class="w-8 h-8 rounded-full object-cover border border-gray-300" />
                            </button>
                        </div>
                    </template>
                    <template v-else>
                        <Link :href="route('home')" class="text-primary font-medium">
                            <i class="fas fa-arrow-left mr-2"></i> হোম পেজ
                        </Link>
                        <button class="bg-accent text-white px-4 py-2 rounded-lg hover:bg-orange-600">
                            টাস্কার হোন
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </nav>
</template>