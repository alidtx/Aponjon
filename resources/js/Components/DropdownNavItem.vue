<script setup>
import { Link } from '@inertiajs/vue3';
import { MenuItem } from '@headlessui/vue'

defineProps({
    href: String,
    label: String,
    icon: Object, 
    method: {
        type: String,
        default: 'get'
    },
    as: {
        type: String,
        default: 'a'
    }
});
</script>

<template>
    <MenuItem v-slot="{ active }">
        <Link
            :href="href"
            :method="method"
            :as="as"
            :class="[
                active ? 'bg-primary text-white' : 'text-gray-900',
                'group flex w-full items-center rounded-md px-2 py-2 text-sm'
            ]"
        >
            <component :is="icon" class="mr-2 h-5 w-5 text-violet-400" />
            {{ label }}
        </Link>
    </MenuItem>
</template>