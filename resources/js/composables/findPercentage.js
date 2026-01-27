import { computed, unref } from 'vue'

export function findPercentage(t, tt) {
    return computed(() => {
        const list = unref(t) ?? []
        const total = Number(unref(tt))

        if (!list.length || !total || isNaN(total)) return 0

        return Math.round((list.length / total) * 100)
    })
}
