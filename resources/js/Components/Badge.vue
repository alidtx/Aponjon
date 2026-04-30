<script setup>
import { twMerge } from 'tailwind-merge'

const props = defineProps({
    text: {
        type: String,
        required: true,
    },
    type: {
        type: String,
        default: 'capsule',
    },
    size: {
        type: String,
        default: 'lg',
    },
    status: {
        type: String,
        default: 'processing',
    },
})
const typeClasses = {
    capsule: 'rounded-full',
    rounded: 'rounded-md',
}
const sizeClasses = {
    lg: 'text-base/regular px-2 py-1',
    md: 'text-sm/regular py-1 px-2',
    sm: 'text-xs/regular p-0.5',
}

const statusClasses = {
    processing: 'text-white bg-primary-500 border-none',
    used: 'text-white bg-primary-500 border-none',
    pending: 'text-white bg-yellow-500 border-none',
    requested: 'text-white bg-yellow-500 border-none',
    rejected: 'text-white bg-red-500 border-none',
    approved: 'text-white bg-green-500 border-none',
    success: 'text-white bg-green-500 border-none',
    cancelled: 'text-white bg-red-500 border-none',
    customer_aborted: 'text-white bg-red-500 border-none',
    failed: 'text-white bg-red-500 border-none',
    not_settled: 'text-white bg-primary-400 border-none',
    requested_for_settlement: 'text-white bg-primary-300 border-none',
    requested_to_bank: 'text-white bg-primary-300 border-none',
    bank_acknowledged: 'text-white bg-primary-400 border-none',
    partially_settled: 'text-white bg-green-300 border-none',
    settled: 'text-white bg-green-500 border-none',
    refunded: 'text-white bg-green-500 border-none',
    partial_refunded: 'text-white bg-green-300 border-none',
    settlement_in_progress: 'text-white bg-primary-300 border-none',
    refund_in_progress: 'text-white bg-primary-500 border-none',
    awaiting_for_merchant_approval: 'text-white bg-primary-500 border-none',
    initiated: 'text-white bg-system-status-initiated border-none',
    accepted: 'text-white bg-system-status-accepted border-none',
    denied: 'text-white bg-system-status-denied border-none',
}
</script>

<template>
    <div
        :class="
            twMerge(
                'flex items-center justify-start gap-1 border border-brand-primary-border-darker bg-brand-primary-surface-default text-brand-grayscale-border-white',
                sizeClasses[props.size.toLowerCase()],
                typeClasses[props.type.toLowerCase()],
                statusClasses[props.status.toLowerCase()],
                $attrs.class,
            )
        "
    >
        <slot name="iconLeft" />
        <p>
            {{ text.replace(/_/g, ' ') }}
        </p>
        <slot name="iconRight" />
    </div>
</template>

<style scoped></style>
