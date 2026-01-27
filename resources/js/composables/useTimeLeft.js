import { computed } from 'vue'

export function useTimeLeft(dateTime) {
    return computed(() => {
        if (!dateTime?.value) return 'সময় পাওয়া যায়নি'

        const now = new Date()
        const end = new Date(dateTime.value.replace(' ', 'T'))
        const diffSeconds = Math.floor((end - now) / 1000)

        if (diffSeconds <= 0) return 'আবেদনের সময় শেষ হয়েছে'

        const days = Math.floor(diffSeconds / 86400)
        const hours = Math.floor((diffSeconds % 86400) / 3600)
        const minutes = Math.floor((diffSeconds % 3600) / 60)
        const seconds = diffSeconds % 60

        if (days > 0) return `${days} দিন ${hours} ঘন্টা বাকি`
        if (hours > 0) return `${hours} ঘন্টা ${minutes} মিনিট বাকি`
        if (minutes > 0) return `${minutes} মিনিট ${seconds} সেকেন্ড বাকি`
        return `${seconds} সেকেন্ড বাকি`
    })
}
