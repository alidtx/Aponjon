<script setup>
import TextInput from '@/Components/TextInput.vue'
import { ref, watch, computed, onUnmounted } from 'vue'
import { router } from '@inertiajs/vue3'
import debounce from 'lodash.debounce'
import SelectInput from '@/Components/SelectInput.vue';
import InputLabel from '@/Components/InputLabel.vue';

const search = ref('')
const loading = ref(false)
const sortBy = ref('newest')



const emit = defineEmits(['loading-change', 'search-triggered'])

const debouncedSearch = debounce(() => {
    if (shouldSearch.value) {
        loadMarketplace()
    }
}, 400, { trailing: true })

const buildQuery = () => {
    const query = {}
    const searchValue = search.value.trim()

    if (searchValue.length >= 3) {
        query.keyword = searchValue
    }

    if (sortBy.value) {
        query.sort = sortBy.value
    }

    return query
}

const Options = [
    { value: 'newest', label: 'নতুন প্রথম' },
    { value: 'oldest', label: 'পুরানো প্রথম' },
    { value: 'budget_high', label: 'বাজেট (উচ্চ থেকে নিম্ন)' },
    { value: 'budget_low', label: 'বাজেট (নিম্ন থেকে উচ্চ)' },
    { value: 'urgent', label: 'জরুরি প্রথম' },
]

const shouldSearch = computed(() => {
    const searchValue = search.value.trim()
    return searchValue.length === 0 || searchValue.length >= 3
})

watch(search, (newValue, oldValue) => {
    if (newValue.trim() === oldValue.trim()) return
    debouncedSearch()
}, { flush: 'sync' })

watch(sortBy, () => {
    loadMarketplace()
})

const loadMarketplace = () => {
    if (loading.value) return

    emit('search-triggered')
    loading.value = true
    emit('loading-change', true)

    router.visit(route('marketplace'), {
        data: buildQuery(),
        preserveState: true,
        replace: true,
        preserveScroll: true,
        onFinish: () => {
            loading.value = false
            emit('loading-change', false)
        },
    })
}

const refreshSearch = () => {
    loadMarketplace()
}

defineExpose({
    refreshSearch
})

onUnmounted(() => {
    debouncedSearch.cancel()
})
</script>

<template>
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4">
                <span class="text-gray-700">সর্বমোট <strong>১,২৫৪টি</strong> টাস্ক</span>
            </div>
            <div class="flex items-center space-x-2 ">
                <div class="flex items-center">
                    <InputLabel for="সাজান" value="সাজান" class="text-gray-700 mr-2"/>
                    <SelectInput 
                        class="border border-gray-300 rounded-lg p-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                        defaultVal="নির্বাচন করুন" :options="Options" labelKey="label" valueKey="value"
                        v-model="sortBy" />
                </div>
                <div class="relative">
                    <TextInput
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg w-96 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                        v-model="search" placeholder="টাস্ক খুঁজুন..." @keyup.enter="loadMarketplace"
                        :disabled="loading" />
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    <span v-if="loading" class="absolute right-3 top-3 text-blue-500">
                        <i class="fas fa-spinner fa-spin"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>