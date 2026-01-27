import { computed, unref } from 'vue'

export function useBidsAverageAmount(bids) {
    return computed(() => {
        const list = unref(bids)

        if (!list || list.length === 0) return 0

        const totalAmount = list.reduce(
            (sum, bid) => sum + Number(bid.amount || 0),
            0
        )

        return Math.round(totalAmount / list.length)
    })
}
