<script setup>
defineProps({
    title: String,
    items: Array,

    wrapperClass: {
        type: String,
        default: 'bg-white rounded-2xl shadow-lg border border-gray-200 p-6'
    },

    titleClass: {
        type: String,
        default: 'text-xl font-bold text-gray-800 mb-4 flex items-center'
    },

    iconClass: String
})
</script>


<template>
    <div :class="wrapperClass">

        <h3 :class="titleClass">
            <i :class="iconClass"></i>
            {{ title }}
        </h3>

        <div class="space-y-3">
            <div v-for="(item, index) in items" :key="index" class="flex items-start">
                <div v-if="item.circle" class="w-8 h-8 rounded-full flex items-center justify-center mr-3 flex-shrink-0"
                    :class="item.circleBg">
                    <i :class="item.icon"></i>
                </div>

                <i v-else :class="item.icon" class="mt-1 mr-3"></i>

                <div>
                    <p class="font-medium text-gray-800" v-if="item.title">
                        {{ item.title }}
                    </p>
                    <p class="text-sm text-gray-600">
                        {{ item.text }}
                    </p>
                </div>
            </div>
        </div>
        <slot name="footer" />
    </div>
</template>
