<script setup>
import TextInput from '@/Components/TextInput.vue'
import { ref, watch, computed, onUnmounted } from 'vue'
import { router } from '@inertiajs/vue3'
import debounce from 'lodash.debounce'

const search = ref('')
const loading = ref(false)

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
  
  return query
}

const shouldSearch = computed(() => {
  const searchValue = search.value.trim()
  return searchValue.length === 0 || searchValue.length >= 3
})

watch(search, (newValue, oldValue) => {
  
  if (newValue.trim() === oldValue.trim()) return
  
  debouncedSearch()
}, { flush: 'sync' })

const loadMarketplace = () => {
  
  if (loading.value) return
  
  loading.value = true

  router.visit(route('marketplace'), {
    data: buildQuery(),
    preserveState: true,
    replace: true,
    preserveScroll: true, 
    onFinish: () => {
      loading.value = false
    },
  })
}

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
      <div class="flex items-center space-x-4">
        <div class="flex items-center">
          <span class="text-gray-700 mr-2">সাজান:</span>
          <select 
            class="border border-gray-300 rounded-lg p-2"
            @change="loadMarketplace"
            v-model="sortBy"
          >
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
            v-model.lazy="search" 
            placeholder="টাস্ক খুঁজুন..."
            @keyup.enter="loadMarketplace" 
          />
          <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
          <span 
            v-if="loading" 
            class="absolute right-3 top-3 text-blue-500"
          >
            <i class="fas fa-spinner fa-spin"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
</template>