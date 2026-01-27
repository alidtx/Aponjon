import { computed, unref } from 'vue'

export function useTimeAgo(dateTime) {
    return computed(() => {
        const value = unref(dateTime)
        if (!value) return ''

        const now = new Date()
        const past = new Date(value.replace(' ', 'T'))
        const diffSeconds = Math.floor((now - past) / 1000)

        if (diffSeconds < 60) {
            return `${diffSeconds} সেকেন্ড আগে`
        }

        const diffMinutes = Math.floor(diffSeconds / 60)
        if (diffMinutes < 60) {
            return `${diffMinutes} মিনিট আগে`
        }

        const diffHours = Math.floor(diffMinutes / 60)
        if (diffHours < 24) {
            return `${diffHours} ঘন্টা আগে`
        }

        const diffDays = Math.floor(diffHours / 24)
        return `${diffDays} দিন আগে`
    })
}
