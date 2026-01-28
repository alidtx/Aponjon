import { computed, unref } from 'vue'

export function useBidAmounts(bids) {
  return computed(() => {
    const list = unref(bids)

    if (!list || !list.length) {
      return {
        lowest: null,
        highest: null
      }
    }

    const amounts = list.map(bid => Number(bid.amount))

    return {
      lowest: Math.min(...amounts),
      highest: Math.max(...amounts)
    }
  })
}
