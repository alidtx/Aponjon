<script setup>
import { onMounted, ref, nextTick } from 'vue'
// import Badge from '@/Components/Badge.vue'
import SmallThumbnail from '../Icons/SmallThumbnail.vue'
import AngleUpIcon from '../Icons/AngleUpIcon.vue'
import { throttle } from 'lodash-es'
import NoItemFound from '../NoItemFound.vue'

const props = defineProps({
    tableHeader: {
        type: Array,
        default: () => [],
    },
    tableData: {
        type: Array,
        default: () => [],
    },
    hasMorePages: {
        type: Boolean,
        default: false,
    },
    currentPage: {
        type: Number,
        default: 1,
    },
})

const emit = defineEmits(['updateColumns', 'rowClicked', 'getFilteredResults'])

const columns = ref(
    localStorage.getItem('tableColumns') ? JSON.parse(localStorage.getItem('tableColumns')) : props.tableHeader,
)
const dataArray = ref(props.tableData)
const countClick = ref(0)
const sortIcon = ref({})
const sort = ref('asc')
const scrollContainer = ref(null)
const isLoading = ref(false)

onMounted(() => {
    columns.value = localStorage.getItem('tableColumns')
        ? JSON.parse(localStorage.getItem('tableColumns'))
        : props.tableHeader

    if (props.currentPage > 2) {
        nextTick(() => {
            if (scrollContainer.value) {
                const tableElement = scrollContainer.value.querySelector('table')
                if (tableElement) {
                    scrollContainer.value.scrollTop = localStorage.getItem('scrollPosition')
                }
            }
        })
    }
})

const sortData = (column, order) => {
    countClick.value += 1
    sort.value = order === 'desc' ? 'asc' : 'desc'

    if (countClick.value > 2) {
        dataArray.value = props.tableData
        countClick.value = 0
        sort.value = 'asc'
        return
    }

    sortIcon.value = {
        column,
        order: sort,
    }

    const getNestedValue = (obj, path) => {
        return path.split('.').reduce((acc, part) => acc && acc[part], obj)
    }

    const isNumber = (value) => {
        return typeof value === 'string' && /^-?\d+(\.\d+)?$/.test(value.replace(/,/g, ''))
    }

    const isDate = (value) => {
        return typeof value === 'string' && !isNaN(Date.parse(value))
    }

    dataArray.value = [...props.tableData].sort((a, b) => {
        let valA = getNestedValue(a, column)
        let valB = getNestedValue(b, column)

        if (valA === undefined || valB === undefined) {
            return 0
        }

        if (isNumber(valA) && isNumber(valB)) {
            valA = parseFloat(valA.replace(/,/g, '')) || 0
            valB = parseFloat(valB.replace(/,/g, '')) || 0
        } else if (isDate(valA) && isDate(valB)) {
            valA = new Date(valA).getTime()
            valB = new Date(valB).getTime()
        } else {
            valA = String(valA).toLowerCase()
            valB = String(valB).toLowerCase()
        }

        if (valA < valB) {
            return order === 'asc' ? -1 : 1
        }
        if (valA > valB) {
            return order === 'asc' ? 1 : -1
        }
        scrollContainer.value.scrollTop = 0
        return 0
    })
}

const getObjValue = (obj, path) => {
    return path.split('.').reduce((acc, part) => acc && acc[part], obj)
}

const handleScroll = throttle(async (event) => {
    const target = event.target
    const { scrollTop, scrollHeight, clientHeight } = target
    const scrollThreshold = 50

    if (!isLoading.value && scrollHeight - (scrollTop + clientHeight) < scrollThreshold) {
        localStorage.setItem('scrollPosition', target.scrollTop)
        if (props.hasMorePages) {
            emit('getFilteredResults', '', true)
        }
    }
}, 200)
</script>

<template>
    <div class="bg-white">
        <div
            ref="scrollContainer"
            class="table-container relative h-[calc(100vh-17vh)] overflow-auto rounded-md border border-brand-grayscale-border-default"
            @scroll="handleScroll"
        >
            <table class="min-w-full table-auto p-0">
                <!-- Fixed header styling -->
                <thead>
                    <tr>
                        <th
                            class="border-brand-gray-surface-default sticky top-[-1px] z-30 h-10 text-nowrap border-b border-l bg-brand-grayscale-surface-subtle p-1 text-left text-base capitalize leading-5 first:rounded-tl-[6px] first:border-l-0 last:rounded-tr-[6px]"
                            v-for="(header, index) in columns"
                            :key="index"
                            :class="{
                                'z-40': index === 0,
                                'right-0 z-50 cursor-none': index === columns.length - 1,
                            }"
                            :style="{ width: index === columns.length - 1 ? '50px padding: 0' : 'auto' }"
                        >
                            <div
                                class="flex cursor-pointer items-center justify-between gap-3 px-3 py-2 font-inter font-normal text-brand-grayscale-text-light transition-colors"
                                :class="{
                                    'hover:rounded-sm hover:bg-brand-grayscale-surface-light hover:text-brand-grayscale-text-subtle':
                                        index !== columns.length - 1,
                                    'hover:cursor-none': index === columns.length - 1,
                                }"
                                @click="sortData(header.data, sort)"
                            >
                                <div class="mr-1">{{ header.name }}</div>
                                <div
                                    v-if="header.orderable"
                                    class="relative inline-grid text-gray-400"
                                >
                                    <span class="cursor-pointer">
                                        <AngleUpIcon
                                            class="h-2.5 w-2.5"
                                            :color="
                                                sortIcon?.column === header.data &&
                                                sortIcon?.order === 'asc' &&
                                                countClick
                                                    ? '#0FA9E5'
                                                    : '#6A7282'
                                            "
                                        />
                                    </span>
                                    <span class="cursor-pointer">
                                        <AngleDownIcon
                                            class="h-2.5 w-2.5"
                                            :color="
                                                sortIcon?.column === header.data &&
                                                sortIcon?.order === 'desc' &&
                                                countClick
                                                    ? '#0FA9E5'
                                                    : '#6A7282'
                                            "
                                        />
                                    </span>
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>

                <tbody v-if="dataArray.length > 0">
                    <tr
                        v-for="(row, index) in dataArray"
                        :key="index"
                        class="cursor-pointer hover:bg-brand-grayscale-surface-light hover:text-brand-grayscale-text-subtle"
                        @click="emit('rowClicked', row)"
                    >
                        <td
                            class="h-9 text-nowrap border-b border-l border-brand-grayscale-border-default px-4 py-1 text-start text-base leading-5 text-brand-grayscale-text-title first:border-l-0"
                            v-for="(header, i) in columns"
                            :key="i"
                            :class="{
                                'z-30': i === 0,
                                'sticky right-0 z-40 bg-white pl-0.5 pr-0 text-center': i === columns.length - 1,
                            }"
                        >
                            <div
                                class="flex items-center gap-1"
                                v-if="header.contentType === 'text'"
                            >
                                <div v-if="header.icon">
                                    <span class="font-bold text-primary-950">{{ header.icon }}</span>
                                    {{ getObjValue(dataArray[index], header.data) }}
                                </div>
                                <div v-else-if="header.isLabel">
                                    <Badge
                                        :text="getObjValue(dataArray[index], header.data)"
                                        type="capsule"
                                        size="md"
                                        :status="getObjValue(dataArray[index], header.data)"
                                    />
                                </div>
                                <span v-else>{{ getObjValue(dataArray[index], header.data) ?? 'N/A' }}</span>
                            </div>
                            <div
                                class="flex items-center justify-start gap-1"
                                v-else-if="header.contentType === 'text-image'"
                            >
                                <SmallThumbnail :src="getObjValue(dataArray[index], header.imagePath)" />
                                <span>{{ getObjValue(dataArray[index], header.data) }}</span>
                            </div>
                            <div
                                class="flex items-center justify-start gap-1"
                                v-else-if="header.contentType === 'image'"
                            >
                                <SmallThumbnail :src="getObjValue(dataArray[index], header.imagePath)" />
                            </div>
                            <div
                                class="flex items-center"
                                v-else-if="header.contentType === 'slots'"
                                @click.stop
                            >
                                <slot
                                    :name="header.slotsName"
                                    :id="dataArray[index].id"
                                    :rowData="dataArray[index]"
                                >
                                </slot>
                            </div>
                        </td>
                    </tr>
                </tbody>

                <tbody v-else>
                    <tr>
                        <td
                            class="text-nowrap border-t-0 text-center text-lg"
                            colspan="100%"
                        >
                            <div class="flex h-[calc(100vh-25vh)] items-center justify-center">
                                <NoItemFound />
                            </div>
                        </td>
                    </tr>
                </tbody>
                <tfoot class="fixed bottom-0">
                    <tr>
                        <td class="sticky bottom-0 z-40"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</template>

<style scoped>
table {
    position: relative;
    border-collapse: separate;
    border-spacing: 0;
}
</style>
