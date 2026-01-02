<script setup>

import { computed } from 'vue'

const props = defineProps({
  totalTask: Number,
  activeTasker: Number,
  totalBudget: [Number, String],
})

const roundedBudgetInLakh = computed(() => {
  const budget = Number(props.totalBudget) || 0
  return Math.round(budget) 
})

</script>

<template>
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
            <div>
                <div class="text-2xl font-bold text-primary">{{totalTask}}</div>
                <div class="text-sm text-gray-600">সক্রিয় টাস্ক</div>
            </div>
            <div>
                <div class="text-2xl font-bold text-green-600">৳ {{roundedBudgetInLakh}} লাখ+</div>
                <div class="text-sm text-gray-600">মোট বাজেট</div>
            </div>
            <div>
                <div class="text-2xl font-bold text-blue-600">{{ activeTasker }}</div>
                <div class="text-sm text-gray-600">সক্রিয় টাস্কার</div>
            </div>
            <div>
                <div class="text-2xl font-bold text-orange-600">৯৪%</div>
                <div class="text-sm text-gray-600">সফলতার হার</div>
            </div>
        </div>
    </div>
</template>