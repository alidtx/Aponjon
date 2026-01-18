<script setup>
import TextInput from '@/Components/TextInput.vue'
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'

const search = ref('')
const loading = ref(false)

let debounceTimer = null

watch(search, (value) => {
    clearTimeout(debounceTimer)

    debounceTimer = setTimeout(() => {
        loadMarketplace()
    }, 400)
})

const loadMarketplace = () => {
    loading.value = true

    router.visit(route('marketplace'), {
        data: buildQuery(),
        preserveState: true,
        replace: true,
        onFinish: () => {
            loading.value = false
        },
    })
}

const buildQuery = () => {
    const query = {}

    if (search.value && search.value.length >= 5) {
        query.keyword = search.value
    }

    return query
}
</script>

<template>
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700">সর্বমোট <strong>১,২৫৪টি</strong> টাস্ক</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <span class="text-gray-700 mr-2">সাজান:</span>
                            <select class="border border-gray-300 rounded-lg p-2">
                                <option value="newest">নতুন প্রথম</option>
                                <option value="oldest">পুরানো প্রথম</option>
                                <option value="budget_high">বাজেট (উচ্চ থেকে নিম্ন)</option>
                                <option value="budget_low">বাজেট (নিম্ন থেকে উচ্চ)</option>
                                <option value="urgent">জরুরি প্রথম</option>
                            </select>
                        </div>
                        <div class="relative">
                            <TextInput
                             class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg w-64"
                              v-model="search"
                             placeholder="টাস্ক খুঁজুন..."
                            />
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
</template>