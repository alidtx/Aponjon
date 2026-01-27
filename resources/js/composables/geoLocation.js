import { computed, unref } from 'vue'

export function useLocation(task) {
    return computed(() => {
        const value = unref(task)
        if (!value) return ''

        return [
            value.district?.name,
            value.zila?.name,
            value.upozila?.name
        ]
            .filter(Boolean)
            .join(', ')
    })
}
