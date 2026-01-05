<script setup>
import {onMounted, ref } from 'vue'
import Checkbox from '@/Components/Checkbox.vue';
import axios from 'axios'

const category = ref({ data: [] }); // Initialize as object with data property
const loading = ref(false)
const error = ref(null)
const fetchCategoryList = async () => {
    try {
        const response = await axios.get(route('category'), {})
        category.value = response.data

    } catch (err) {
        error.value = 'Failed to fetch catetory list.'
    } finally {
        loading.value = false
    }
}

onMounted(() => {
    fetchCategoryList()
})
</script>


<template>
    <div class="lg:w-1/4">
        <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
            <h3 class="text-lg font-bold text-dark mb-4">ফিল্টার করুন</h3>
            <div class="mb-6">
                <label class="block font-medium text-dark mb-3">সেবা ক্যাটাগরি</label>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <Checkbox class="rounded text-primary" checked/>
                        <span class="ml-2 text-gray-700">সকল ক্যাটাগরি</span>
                    </label>
                    <label class="flex items-center" 
                     v-for="(item, index) in category.data" 
                            :key="item.id || index"
                    >  
                        <Checkbox class="rounded text-primary"  :value="item.slug"/>
                        <span class="ml-2 text-gray-700">{{ item.name }}</span>
                        <span class="ml-auto text-gray-500"> ({{ item.task?.length || 0 }})</span>
                    </label>
                    
                </div>
            </div>
            <div class="mb-6">
                <label class="block font-medium text-dark mb-3">লোকেশন</label>
                <select class="w-full p-2 border border-gray-300 rounded-lg">
                    <option value="">সকল এলাকা</option>
                    <option value="dhaka">ঢাকা</option>
                    <option value="chattogram">চট্টগ্রাম</option>
                    <option value="khulna">খুলনা</option>
                    <option value="rajshahi">রাজশাহী</option>
                </select>
            </div>

            <!-- Budget Filter -->
            <div class="mb-6">
                <label class="block font-medium text-dark mb-3">বাজেট রেঞ্জ</label>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="radio" name="budget" class="text-primary" checked>
                        <span class="ml-2 text-gray-700">সকল বাজেট</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="budget" class="text-primary">
                        <span class="ml-2 text-gray-700">৳৫০০ এর নিচে</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="budget" class="text-primary">
                        <span class="ml-2 text-gray-700">৳৫০০ - ৳১,০০০</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="budget" class="text-primary">
                        <span class="ml-2 text-gray-700">৳১,০০০ - ৳২,০০০</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="budget" class="text-primary">
                        <span class="ml-2 text-gray-700">৳২,০০০+</span>
                    </label>
                </div>
            </div>

            <div class="mb-6">
                <label class="block font-medium text-dark mb-3">জরুরিতা</label>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded text-primary" checked>
                        <span class="ml-2 text-gray-700">সকল</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded text-primary">
                        <span class="ml-2 text-red-600">
                            <i class="fas fa-bolt mr-1"></i>ইমার্জেন্সি
                        </span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded text-primary">
                        <span class="ml-2 text-orange-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>জরুরি
                        </span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded text-primary">
                        <span class="ml-2 text-green-600">সাধারণ</span>
                    </label>
                </div>
            </div>

            <button class="w-full bg-primary text-white py-2 rounded-lg hover:bg-blue-700 font-medium">
                ফিল্টার প্রয়োগ করুন
            </button>
        </div>
    </div>
</template>