import { computed, unref } from 'vue'

export function findPercentage(t, tt) {
    
    return computed(() => {
        const value = unref(t)
        const total = unref(tt)
        if (value == null || total == null) return 0
        if (Array.isArray(value) && Array.isArray(total)) {
            if (!total.length) return 0
            return Math.round((value.length / total.length) * 100)
        }
        const num = Number(value)
        const totalNum = Number(total)

        if (isNaN(num) || isNaN(totalNum) || totalNum === 0) return 0

        return Math.round((num / totalNum) * 100)
    })
}
