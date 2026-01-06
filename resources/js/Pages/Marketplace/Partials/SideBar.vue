<script setup>
import { onMounted, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import Checkbox from '@/Components/Checkbox.vue'
import axios from 'axios'

const props = defineProps({
    query: {
        type: Object,
        required: true
    }
})

const category = ref({ data: [] })
const loading = ref(false)
const error = ref(null)
const slug = ref(
    props.query?.slug ? [].concat(props.query.slug) : []
)

const fetchCategoryList = async () => {
    loading.value = true
    try {
        const response = await axios.get(route('category'))
        category.value = response.data
    } catch (err) {
        error.value = 'Failed to fetch category list.'
    } finally {
        loading.value = false
    }
}

const getFilteredResults = (currentPage = 1) => {
    router.visit(route('marketplace'), {
        data: getQuery(currentPage),
        preserveState: true,
        replace: true,
    })
}

const getQuery = (currentPage = 1) => {
    const data = {
        current_page: currentPage,
    }

    if (slug.value.length) {
        data.slug = slug.value
    }

    return data
}

const resetFilters = () => {
    slug.value = []
    router.visit(route('marketplace'), {
        data: {},          
        preserveState: true,
        replace: true,
    })
}

onMounted(fetchCategoryList)
</script>

<template>
    <div class="lg:w-1/4">
        <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-dark">ফিল্টার করুন</h3>
                <button 
                    @click="resetFilters"
                    class="text-sm text-primary hover:text-blue-700 font-medium"
                >
                    সব ফিল্টার রিসেট
                </button>
            </div>
            <div class="mb-6">
                <label class="block font-medium text-dark mb-3">
                    সেবা ক্যাটাগরি
                </label>

                <div class="space-y-2 mb-6">
                    <label class="flex items-center">
                        <Checkbox
                            class="rounded text-primary"
                            :checked="slug.length === 0"
                            @change="slug = []"
                        />
                        <span class="ml-2 text-gray-700">
                             সব ক্যাটাগরি
                        </span>
                    </label>
                    <label
                        class="flex items-center"
                        v-for="item in category.data"
                        :key="item.id"
                    >
                        <Checkbox
                            class="rounded text-primary"
                            :value="item.slug"
                            v-model:checked="slug"
                        />
                        <span class="ml-2 text-gray-700">
                            {{ item.name }}
                        </span>
                        <span class="ml-auto text-gray-500">
                            ({{ item.task?.length || 0 }})
                        </span>
                    </label>

                </div>
                 <!-- Location Filter -->
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
            </div>
            <button
                class="w-full bg-primary text-white py-2 rounded-lg hover:bg-blue-700 font-medium"
                @click="getFilteredResults()"
            >
                ফিল্টার প্রয়োগ করুন
            </button>
        </div>
    </div>
</template>