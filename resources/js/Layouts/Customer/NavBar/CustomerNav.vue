<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';


 const props= defineProps({
      user:{
         type: Object,
         required:true   
      }
 })
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
                    <a href="marketplace.html" class="text-dark hover:text-primary">টাস্কস</a>
                    <a href="post-task.html" class="bg-accent text-white px-4 py-2 rounded-lg hover:bg-orange-600">
                        টাস্ক পোস্ট করুন
                    </a>
                    <div class="relative group">
                        <button class="flex items-center space-x-2">
                            <span class="text-dark">{{props.user?.data?.name}}</span>
                            <img :src="props.user?.data?.avatar" alt="User Avatar"
                                class="w-8 h-8 rounded-full object-cover border border-gray-300" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>