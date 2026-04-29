<script setup>
import { Menu, MenuButton, MenuItems} from '@headlessui/vue'
import { computed } from 'vue'

const props = defineProps({
    name: {
        type: String,
        default: 'John Doe'
    }
})

const initials = computed(() => {
    if (!props.name) return ''
    return props.name
        .split(' ')
        .map(word => word[0])
        .join('')
        .slice(0, 2)
})
</script>

<template>
    <Menu as="div" class="relative inline-block text-left">
        <div>
            <MenuButton
                class="flex bg-gray-100 cursor-pointer items-center justify-start rounded-full border border-transparent p-0.5 transition duration-300 hover:bg-gray-200 focus:border-primary-500 focus:outline-none md:w-[140px] md:gap-2">
                <div
                    class="h-9 w-9 rounded-full bg-primary text-white flex items-center justify-center text-sm font-semibold tracking-wide uppercase">
                    {{ initials }}
                </div>
                <strong
                    class="line-clamp-1 w-auto font-inter text-sm font-medium text-gray-700 md:w-[70px]">
                    <span class="hidden md:block">{{ name }}</span>
                </strong>
                <slot name="icon" />
            </MenuButton>
        </div>
        <transition
            enter-active-class="transition duration-100 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-in"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
        >
            <MenuItems
                class="absolute right-0 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none">
                <div class="px-1 py-1">
                    <slot name="items" />
                </div>
            </MenuItems>
        </transition>
    </Menu>
</template>