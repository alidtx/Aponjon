<script setup>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'

defineProps({
    title: {
        type: String,
        default: 'বিশেষ নির্দেশনা'
    },
    items: {
        type: Array,
        default: () => []
    },
    accordionId: {
        type: String,
        default: 'special'
    }
})

onMounted(() => {
    initFlowbite()
})
</script>

<template>
    <div
        :id="`accordion-collapse-${accordionId}`"
        data-accordion="collapse"
        class="mt-4 rounded-lg border border-yellow-200 overflow-hidden bg-yellow-50"
    >
        <h2 :id="`accordion-collapse-heading-${accordionId}`">
            <button
                type="button"
                class="flex items-center justify-between w-full p-4 font-medium text-yellow-800 hover:bg-yellow-100 gap-3"
                :data-accordion-target="`#accordion-collapse-body-${accordionId}`"
                aria-expanded="false"
                :aria-controls="`accordion-collapse-body-${accordionId}`"
            >
                <span>{{ title }}</span>

                <svg
                    data-accordion-icon
                    class="w-5 h-5 rotate-180 shrink-0 text-yellow-700"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m5 15 7-7 7 7"
                    />
                </svg>
            </button>
        </h2>

        <div
            :id="`accordion-collapse-body-${accordionId}`"
            class="hidden border-t border-yellow-200"
            :aria-labelledby="`accordion-collapse-heading-${accordionId}`"
        >
            <div class="p-4">
                <!-- Slot fallback -->
                <slot>
                    <ul class="list-disc pl-5 space-y-1 text-yellow-700">
                        <li v-for="(item, index) in items" :key="index">
                            {{ item }}
                        </li>
                    </ul>
                </slot>
            </div>
        </div>
    </div>
</template>
