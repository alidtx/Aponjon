<script setup>
import { ref, watch, computed, onMounted, onUnmounted } from 'vue'
import SmallThumbnail from '../Icons/SmallThumbnail.vue'
import AngleUpIcon from '../Icons/AngleUpIcon.vue'
import AngleDownIcon from '../Icons/AngleDownIcon.vue'
import NoItemFound from '../NoItemFound.vue'


const props = defineProps({
    tableHeader: { type: Array, default: () => [] },
    tableData:   { type: Array, default: () => [] },
    links:       { type: Array, default: () => [] },
    currentPage: { type: Number, default: 1 },
    itemsPerPage: { type: Number, default: 10 },
    responsiveBreakpoint: { type: Number, default: 768 },
    enableColumnToggle: { type: Boolean, default: true },
    searchPlaceholder: { type: String, default: 'Search...' },
})

const emit = defineEmits(['updateColumns', 'rowClicked', 'changePage', 'search'])


const SERIAL_COL = { name: '#', data: 'serial', orderable: false, contentType: 'text' }
const STORAGE_KEY = 'tableColumns'

const getObjValue = (obj, path) => {
    if (!path || path === 'serial') return null
    return path.split('.').reduce((acc, key) => acc?.[key], obj) ?? null
}

const getSerialNumber = (index) =>
    (props.currentPage - 1) * props.itemsPerPage + index + 1


const defaultColumns = [SERIAL_COL, ...props.tableHeader]

const loadStoredColumns = () => {
    try {
        const stored = localStorage.getItem(STORAGE_KEY)
        return stored ? JSON.parse(stored) : defaultColumns
    } catch {
        return defaultColumns
    }
}

const columns = ref(loadStoredColumns())
const visibleColumnNames = ref(new Set(columns.value.map(col => col.name)))
const showColumnManager = ref(false)

const visibleColumns = computed(() =>
    columns.value.filter(col => visibleColumnNames.value.has(col.name))
)

const saveColumnPreferences = () => {
    try {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(visibleColumns.value))
    } catch {
        // localStorage may be unavailable (private browsing, storage full, etc.)
    }
}

const toggleColumn = (name) => {
    if (visibleColumnNames.value.has(name)) {
        visibleColumnNames.value.delete(name)
    } else {
        visibleColumnNames.value.add(name)
    }
    visibleColumnNames.value = new Set(visibleColumnNames.value)
    saveColumnPreferences()
}

const resetColumns = () => {
    columns.value = defaultColumns
    visibleColumnNames.value = new Set(defaultColumns.map(col => col.name))
    saveColumnPreferences()
}


const isMobile = ref(window.innerWidth < props.responsiveBreakpoint)
const handleResize = () => {
    isMobile.value = window.innerWidth < props.responsiveBreakpoint
}


const searchQuery = ref('')
let searchTimer = null

const onSearch = () => {
    clearTimeout(searchTimer)
    searchTimer = setTimeout(() => emit('search', searchQuery.value), 300)
}


const sortState = ref({ column: null, order: 'asc', clicks: 0 })

const sortData = (column) => {
    const s = sortState.value

    if (s.column !== column) {
        sortState.value = { column, order: 'asc', clicks: 1 }
    } else if (s.clicks >= 2) {
        sortState.value = { column: null, order: 'asc', clicks: 0 }
    } else {

        sortState.value = {
            column,
            order: s.order === 'asc' ? 'desc' : 'asc',
            clicks: s.clicks + 1,
        }
    }
}

const filteredData = computed(() => {
    const query = searchQuery.value.trim().toLowerCase()
    const data = query
        ? props.tableData.filter(row =>
              columns.value.some(col => {
                  if (col.data === 'serial') return false
                  const val = getObjValue(row, col.data)
                  return val != null && String(val).toLowerCase().includes(query)
              })
          )
        : props.tableData

    const { column, order } = sortState.value
    if (!column) return data

    return [...data].sort((a, b) => {
        let valA = getObjValue(a, column)
        let valB = getObjValue(b, column)

        const numA = Number(valA)
        const numB = Number(valB)
        if (!isNaN(numA) && !isNaN(numB)) {
            return order === 'asc' ? numA - numB : numB - numA
        }

        valA = String(valA ?? '').toLowerCase()
        valB = String(valB ?? '').toLowerCase()
        if (valA < valB) return order === 'asc' ? -1 : 1
        if (valA > valB) return order === 'asc' ? 1 : -1
        return 0
    })
})

const currentPageData = computed(() => {
    const start = (props.currentPage - 1) * props.itemsPerPage
    return filteredData.value.slice(start, start + props.itemsPerPage)
})

const totalPages = computed(() => props.links?.length ?? 0)

onMounted(() => window.addEventListener('resize', handleResize))
onUnmounted(() => {
    window.removeEventListener('resize', handleResize)
    clearTimeout(searchTimer)
})

watch(() => props.currentPage, () =>
    window.scrollTo({ top: 0, behavior: 'smooth' })
)
</script>

<template>
    <div class="datatable-container bg-white">

        <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <input
                    v-model="searchQuery"
                    type="text"
                    :placeholder="searchPlaceholder"
                    @input="onSearch"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 pl-10 text-sm
                           focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                />
                <svg class="absolute left-3 top-2.5 h-4 w-4 text-gray-400"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <div v-if="enableColumnToggle" class="relative">
                <button
                    @click="showColumnManager = !showColumnManager"
                    class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white
                           px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    Columns
                </button>

                <div
                    v-if="showColumnManager"
                    class="absolute right-0 z-10 mt-2 w-56 rounded-md border border-gray-200 bg-white shadow-lg"
                >
                    <div class="p-2">
                        <div class="mb-2 flex justify-between border-b pb-2">
                            <span class="text-sm font-medium">Toggle Columns</span>
                            <button @click="resetColumns" class="text-xs text-blue-600 hover:text-blue-700">
                                Reset
                            </button>
                        </div>
                        <div class="max-h-64 overflow-y-auto">
                            <label
                                v-for="col in columns"
                                :key="col.name"
                                class="flex cursor-pointer items-center gap-2 rounded px-2 py-1.5 hover:bg-gray-50"
                            >
                                <input
                                    type="checkbox"
                                    :checked="visibleColumnNames.has(col.name)"
                                    @change="toggleColumn(col.name)"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                />
                                <span class="text-sm">{{ col.name }}</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-sm text-gray-500">
                Showing {{ currentPageData.length }} of {{ filteredData.length }} results
            </div>
        </div>
        <div v-if="!isMobile" class="overflow-x-auto rounded-md border border-gray-200">
            <table class="min-w-full border-collapse">
                <thead>
                    <tr>
                        <th
                            v-for="header in visibleColumns"
                            :key="header.name"
                            class="border-b bg-gray-50 px-4 py-3 text-left text-sm font-medium text-gray-700"
                            :class="{ 'cursor-pointer select-none': header.orderable }"
                            @click="header.orderable ? sortData(header.data) : null"
                        >
                            <div class="flex items-center justify-between gap-2">
                                <span>{{ header.name }}</span>
                                <div v-if="header.orderable" class="inline-grid ml-2">
                                    <AngleUpIcon
                                        class="h-2.5 w-2.5"
                                        :color="sortState.column === header.data && sortState.order === 'asc'
                                            ? '#0FA9E5' : '#9CA3AF'"
                                    />
                                    <AngleDownIcon
                                        class="h-2.5 w-2.5 -mt-0.5"
                                        :color="sortState.column === header.data && sortState.order === 'desc'
                                            ? '#0FA9E5' : '#9CA3AF'"
                                    />
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>

                <tbody v-if="currentPageData.length">
                    <tr
                        v-for="(row, index) in currentPageData"
                        :key="row.id ?? index"
                        class="hover:bg-gray-50 transition-colors cursor-pointer"
                        @click="emit('rowClicked', row)"
                    >
                        <td
                            v-for="header in visibleColumns"
                            :key="header.name"
                            class="border-b px-4 py-3 text-sm text-gray-700"
                        >

                            <template v-if="header.data === 'serial'">
                                {{ getSerialNumber(index) }}
                            </template>

                            <template v-else-if="header.contentType === 'text'">
                                {{ getObjValue(row, header.data) ?? 'N/A' }}
                            </template>

                            <template v-else-if="header.contentType === 'text-image'">
                                <div class="flex items-center gap-2">
                                    <SmallThumbnail :src="getObjValue(row, header.imagePath)" />
                                    <span>{{ getObjValue(row, header.data) }}</span>
                                </div>
                            </template>
                            <template v-else-if="header.contentType === 'badge'">
                                <span
                                    :class="getObjValue(row, header.badgeClass)"
                                    class="inline-flex rounded-full px-2 py-1 text-xs font-medium"
                                >
                                    {{ getObjValue(row, header.data) }}
                                </span>
                            </template>
                            <template v-else-if="header.contentType === 'slots'">
                                <slot :name="header.slotsName" :id="row.id" :rowData="row" />
                            </template>
                        </td>
                    </tr>
                </tbody>

                <tbody v-else>
                    <tr>
                        <td :colspan="visibleColumns.length" class="py-10 text-center">
                            <NoItemFound />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-else class="space-y-3">
            <template v-if="currentPageData.length">
                <div
                    v-for="(row, index) in currentPageData"
                    :key="row.id ?? index"
                    class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm cursor-pointer"
                    @click="emit('rowClicked', row)"
                >
                    <div class="mb-3">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">
                            #{{ getSerialNumber(index) }}
                        </span>
                    </div>
                    <div class="space-y-2.5">
                        <div
                            v-for="header in visibleColumns.filter(c => c.data !== 'serial')"
                            :key="header.name"
                            class="flex items-start justify-between gap-4 text-sm"
                        >
                            <span class="shrink-0 w-1/3 font-medium text-gray-500">{{ header.name }}</span>
                            <span class="flex-1 text-right text-gray-900">
                                <template v-if="header.contentType === 'text'">
                                    {{ getObjValue(row, header.data) ?? 'N/A' }}
                                </template>
                                <template v-else-if="header.contentType === 'text-image'">
                                    <div class="flex items-center justify-end gap-2">
                                        <SmallThumbnail :src="getObjValue(row, header.imagePath)" />
                                        <span>{{ getObjValue(row, header.data) }}</span>
                                    </div>
                                </template>
                                <template v-else-if="header.contentType === 'badge'">
                                    <span
                                        :class="getObjValue(row, header.badgeClass)"
                                        class="inline-flex rounded-full px-2 py-1 text-xs font-medium"
                                    >
                                        {{ getObjValue(row, header.data) }}
                                    </span>
                                </template>
                                <template v-else-if="header.contentType === 'slots'">
                                    <slot :name="header.slotsName" :id="row.id" :rowData="row" />
                                </template>
                            </span>
                        </div>
                    </div>
                </div>
            </template>

            <div v-else class="py-10 text-center">
                <NoItemFound />
            </div>
        </div>

        <div v-if="totalPages > 1" class="mt-4 flex flex-wrap items-center justify-between gap-3">
            <div class="text-sm text-gray-500">
                Page {{ currentPage }} of {{ totalPages }}
            </div>
            <div class="flex gap-2">
                <button
                    :disabled="currentPage === 1"
                    @click="emit('changePage', currentPage - 1)"
                    class="rounded-md border border-gray-300 px-3 py-1 text-sm
                           hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    Previous
                </button>
                <button
                    :disabled="currentPage === totalPages"
                    @click="emit('changePage', currentPage + 1)"
                    class="rounded-md border border-gray-300 px-3 py-1 text-sm
                           hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    Next
                </button>
            </div>
        </div>

    </div>
</template>

<style scoped>
.datatable-container { @apply w-full; }

.transition-transform { transition: transform 0.2s ease; }
.rotate-180           { transform: rotate(180deg); }

.max-h-64::-webkit-scrollbar       { width: 6px; }
.max-h-64::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
.max-h-64::-webkit-scrollbar-thumb { background: #888; border-radius: 10px; }
.max-h-64::-webkit-scrollbar-thumb:hover { background: #555; }
</style>