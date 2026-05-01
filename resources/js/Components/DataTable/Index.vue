<script setup>
import { ref, watch } from 'vue'
import SmallThumbnail from '../Icons/SmallThumbnail.vue'
import AngleUpIcon from '../Icons/AngleUpIcon.vue'
import AngleDownIcon from '../Icons/AngleDownIcon.vue'
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
    links: {
        type: Array,
        default: () => [],
    },
    currentPage: {
        type: Number,
        default: 1,
    },
    itemsPerPage: {
        type: Number,
        default: 10,
    },
})

const emit = defineEmits(['updateColumns', 'rowClicked', 'changePage'])

const columns = ref(
    localStorage.getItem('tableColumns')
        ? JSON.parse(localStorage.getItem('tableColumns'))
        : [{ name: '#', data: 'serial', orderable: false, contentType: 'text' }, ...props.tableHeader]
)

const dataArray = ref(props.tableData)
const countClick = ref(0)
const sortIcon = ref({})
const sort = ref('asc')

watch(
    () => props.tableData,
    (newVal) => {
        dataArray.value = newVal
    },
    { immediate: true }
)

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
        order: sort.value,
    }

    const getNestedValue = (obj, path) => {
        return path.split('.').reduce((acc, part) => acc && acc[part], obj)
    }

    dataArray.value = [...props.tableData].sort((a, b) => {
        let valA = getNestedValue(a, column)
        let valB = getNestedValue(b, column)

        valA = String(valA ?? '').toLowerCase()
        valB = String(valB ?? '').toLowerCase()

        if (valA < valB) return order === 'asc' ? -1 : 1
        if (valA > valB) return order === 'asc' ? 1 : -1
        return 0
    })
}

const getObjValue = (obj, path) => {
    return path.split('.').reduce((acc, part) => acc && acc[part], obj)
}

const getSerialNumber = (index) => {
    return ((props.currentPage - 1) * props.itemsPerPage) + index + 1
}
</script>

<template>
    <div class="bg-white">
        <div class="overflow-x-auto rounded-md border border-gray-200">
            <table class="min-w-full border-collapse">
                <thead>
                    <tr>
                        <th
                            v-for="(header, index) in columns"
                            :key="index"
                            class="border-b bg-gray-50 px-4 py-3 text-left text-sm font-medium text-gray-700"
                        >
                            <div
                                class="flex items-center justify-between gap-2 cursor-pointer"
                                @click="header.orderable ? sortData(header.data, sort) : ''"
                            >
                                <span>{{ header.name }}</span>

                                <div
                                    v-if="header.orderable"
                                    class="inline-grid"
                                >
                                    <AngleUpIcon
                                        class="h-2.5 w-2.5"
                                        :color="sortIcon.column === header.data && sortIcon.order === 'asc' ? '#0FA9E5' : '#9CA3AF'"
                                    />
                                    <AngleDownIcon
                                        class="h-2.5 w-2.5"
                                        :color="sortIcon.column === header.data && sortIcon.order === 'desc' ? '#0FA9E5' : '#9CA3AF'"
                                    />
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>

                <tbody v-if="dataArray.length">
                    <tr
                        v-for="(row, index) in dataArray"
                        :key="index"
                        class="hover:bg-gray-50 cursor-pointer"
                        @click="emit('rowClicked', row)"
                    >
                        <td
                            v-for="(header, i) in columns"
                            :key="i"
                            class="border-b px-4 py-3 text-sm text-gray-700"
                        >
                            <div v-if="header.contentType === 'text' && header.data === 'serial'">
                                {{ getSerialNumber(index) }}
                            </div>
                            <div v-else-if="header.contentType === 'text'">
                                {{ getObjValue(row, header.data) ?? 'N/A' }}
                            </div>

                            <div
                                v-else-if="header.contentType === 'text-image'"
                                class="flex items-center gap-2"
                            >
                                <SmallThumbnail :src="getObjValue(row, header.imagePath)" />
                                <span>{{ getObjValue(row, header.data) }}</span>
                            </div>

                            <div v-else-if="header.contentType === 'slots'">
                                <slot
                                    :name="header.slotsName"
                                    :id="row.id"
                                    :rowData="row"
                                />
                            </div>
                        </td>
                    </tr>
                </tbody>

                <tbody v-else>
                    <tr>
                        <td colspan="100%" class="py-10 text-center">
                            <NoItemFound />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>