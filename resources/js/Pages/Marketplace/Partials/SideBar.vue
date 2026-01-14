<script setup>
import { onMounted, ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import Checkbox from '@/Components/Checkbox.vue'
import axios from 'axios'
import {
    Combobox,
    ComboboxInput,
    ComboboxButton,
    ComboboxOptions,
    ComboboxOption,
    TransitionRoot,
} from '@headlessui/vue'
import { CheckIcon, ChevronUpDownIcon, MagnifyingGlassIcon } from '@heroicons/vue/20/solid'
const props = defineProps({
    query: {
        type: Object,
        required: true
    }
})

const category = ref({ data: [] })
const DistrictWiseList = ref({ data: [] })
const ZilaWiseList = ref({ data: [] })
const filteredUpozilaList = ref([])
const loading = ref(false)
const error = ref(null)
const slug = ref(
    props.query?.slug ? [].concat(props.query.slug) : []
)
const scrollBox = ref(null)
const selectedDistrict = ref(null)
const selectedZila = ref(null)
const selectedUpozila = ref(null)
const zilas = ref(null)
const showZila=ref(false)
const showUpozila=ref(false)
const query = ref('')
let scrollTimer = null


const districts = computed(() => DistrictWiseList.value?.data ?? [])
const allZilasData = computed(() => ZilaWiseList.value?.data ?? [])

const handleScroll = () => {
    if (!scrollBox.value) return

    scrollBox.value.classList.add('scrolling')

    clearTimeout(scrollTimer)
    scrollTimer = setTimeout(() => {
        scrollBox.value.classList.remove('scrolling')
    }, 700)
}

const fetchCategoryList = async () => {
    loading.value = true
    try {
        const response = await axios.get(route('category'))
        category.value = response.data
    } catch (err) {
        error.value = 'Failed to fetch category list.'
    } finally {
        loading.value = false
    }
}

const fetchDistrictList = async () => {
    loading.value = true
    try {
        const response = await axios.get(route('district-Wise-zila'))
        DistrictWiseList.value = response.data
    } catch (err) {
        error.value = 'Failed to fetch district list.'
    } finally {
        loading.value = false
    }
}

const fetchZilaList = async () => {
    loading.value = true
    try {
        const response = await axios.get(route('Zila-Wise-upozila'))
        ZilaWiseList.value = response.data
    } catch (err) {
        error.value = 'Failed to fetch zila list.'
    } finally {
        loading.value = false
    }
}
const handleDistrictChange = async (district) => {
    if(district && district.zilas )
    {
      showZila.value=true
      zilas.value=district.zilas
    }
}
const handleUpozilaChange = async (zila) => {
     if(zila){showUpozila.value=true} 
    const zilasArray = JSON.parse(JSON.stringify(allZilasData.value))
    const selectedZila = zilasArray.find(zila => zila.id == zila.id)
    if (selectedZila && selectedZila.upozilas) {
        filteredUpozilaList.value = selectedZila.upozilas
    } else {
        filteredUpozilaList.value = []
    }
     
}

const filteredDistricts = computed(() => {
    if (query.value === '') return districts.value

    return districts.value.filter((item) =>
        item.name.toLowerCase().includes(query.value.toLowerCase())
    )
})

const filteredZilas = computed(() => {
    if (query.value === '') return zilas.value

    return zilas.value.filter((item) =>
        item.name.toLowerCase().includes(query.value.toLowerCase())
    )
})
const filteredUpozilas = computed(() => {
    if (query.value === '') return filteredUpozilaList.value

    return filteredUpozilaList.value.filter((item) =>
        item.name.toLowerCase().includes(query.value.toLowerCase())
    )
})

const getFilteredResults = (currentPage = 1) => {
    router.visit(route('marketplace'), {
        data: getQuery(currentPage),
        preserveState: true,
        replace: true,
    })
}

const getQuery = (currentPage = 1) => {
    const data = {
        current_page: currentPage,
    }

    if (slug.value.length) {
        data.slug = slug.value
    }

    return data
}

const resetFilters = () => {
    slug.value = []
    router.visit(route('marketplace'), {
        data: {},
        preserveState: true,
        replace: true,
    })
}

onMounted(() => {
    fetchCategoryList()
    fetchDistrictList()
    fetchZilaList()
})
</script>

<template>
    <div class="lg:w-1/4">
        <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-dark">ফিল্টার করুন</h3>
                <button @click="resetFilters" class="text-sm text-primary hover:text-blue-700 font-medium">
                    সব ফিল্টার রিসেট
                </button>
            </div>
            <div class="mb-6">
                <label class="block font-medium text-dark mb-3">
                    সেবা ক্যাটাগরি
                </label>

                <div class="space-y-2 mb-6 max-h-60 overflow-y-auto custom-scrollbar" ref="scrollBox"
                    @scroll="handleScroll">
                    <label class="flex items-center">
                        <Checkbox class="rounded text-primary" :checked="slug.length === 0" @change="slug = []" />
                        <span class="ml-2 text-gray-700">
                            সব ক্যাটাগরি
                        </span>
                    </label>
                    <label class="flex items-center" v-for="item in category.data" :key="item.id">
                        <Checkbox class="rounded text-primary" :value="item.slug" v-model:checked="slug" />
                        <span class="ml-2 text-gray-700">
                            {{ item.name }}
                        </span>
                        <span class="ml-auto text-gray-500">
                            ({{ item.task?.length || 0 }})
                        </span>
                    </label>

                </div>
                <div class="mb-6">
                    <label class="block font-medium text-dark mb-3">লোকেশন</label>
                    <div>
                        <Combobox v-model="selectedDistrict" @update:modelValue="handleDistrictChange">
                            <div class="relative mt-1">
                                <div
                                    class="relative w-full cursor-default overflow-hidden rounded-lg border border-gray-300 bg-white text-left sm:text-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <MagnifyingGlassIcon class="h-5 w-5 text-gray-400" />
                                    </div>
                                    <ComboboxInput
                                        class="w-full border-none py-2 pl-10 pr-10 text-sm leading-5 text-gray-900 focus:ring-0"
                                        :displayValue="(item) => item?.name ?? ''"
                                        @change="query = $event.target.value" 
                                        
                                        />
                                    <ComboboxButton class="absolute inset-y-0 right-0 flex items-center pr-2">
                                        <ChevronUpDownIcon class="h-5 w-5 text-gray-400" />
                                    </ComboboxButton>
                                </div>

                                <TransitionRoot leave="transition ease-in duration-100" leaveFrom="opacity-100"
                                    leaveTo="opacity-0" @after-leave="query = ''">
                                    <ComboboxOptions
                                        class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black/5 focus:outline-none sm:text-sm">
                                        <div v-if="filteredDistricts.length === 0 && query !== ''"
                                            class="relative cursor-default select-none px-4 py-2 text-gray-700">
                                            Nothing found.
                                        </div>

                                        <ComboboxOption v-for="district in filteredDistricts" :key="district.id"
                                            :value="district" v-slot="{ selected, active }">
                                            <li class="relative cursor-default select-none py-2 pl-10 pr-4" :class="{
                                                'bg-teal-600 text-white': active,
                                                'text-gray-900': !active,
                                            }">
                                                <span class="block truncate" :class="{ 'font-medium': selected }">
                                                    {{ district.name }}
                                                </span>

                                                <span v-if="selected"
                                                    class="absolute inset-y-0 left-0 flex items-center pl-3">
                                                    <CheckIcon class="h-5 w-5" />
                                                </span>
                                            </li>
                                        </ComboboxOption>
                                    </ComboboxOptions>
                                </TransitionRoot>
                            </div>
                        </Combobox>

                    </div>
                </div>
                <!-- Zila -->
                <div class="mb-6">
                   <div>
                    <transition
                        enter-active-class="transition-all duration-300 ease-out"
                        leave-active-class="transition-all duration-200 ease-in"
                        enter-from-class="opacity-0 transform -translate-y-4"
                        leave-to-class="opacity-0 transform -translate-y-4"
                    >  
                    <div v-if="showZila" class="relative">
                        <Combobox v-model="selectedZila" @update:modelValue="handleUpozilaChange">
                            <div class="relative mt-1">
                                <div
                                    class="relative w-full cursor-default overflow-hidden rounded-lg border border-gray-300 bg-white text-left sm:text-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <MagnifyingGlassIcon class="h-5 w-5 text-gray-400" />
                                    </div>
                                    <ComboboxInput
                                        class="w-full border-none py-2 pl-10 pr-10 text-sm leading-5 text-gray-900 focus:ring-0"
                                        :displayValue="(item) => item?.name ?? ''"
                                        @change="query = $event.target.value" />
                                    <ComboboxButton class="absolute inset-y-0 right-0 flex items-center pr-2">
                                        <ChevronUpDownIcon class="h-5 w-5 text-gray-400" />
                                    </ComboboxButton>
                                </div>

                                <TransitionRoot leave="transition ease-in duration-100" leaveFrom="opacity-100"
                                    leaveTo="opacity-0" @after-leave="query = ''">
                                    <ComboboxOptions
                                        class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black/5 focus:outline-none sm:text-sm">
                                        <div v-if="filteredZilas.length === 0 && query !== ''"
                                            class="relative cursor-default select-none px-4 py-2 text-gray-700">
                                            Nothing found.
                                        </div>

                                        <ComboboxOption v-for="zila in filteredZilas" :key="zila.id"
                                            :value="zila" v-slot="{ selected, active }">
                                            <li class="relative cursor-default select-none py-2 pl-10 pr-4" :class="{
                                                'bg-teal-600 text-white': active,
                                                'text-gray-900': !active,
                                            }">
                                                <span class="block truncate" :class="{ 'font-medium': selected }">
                                                    {{ zila.name }}
                                                </span>

                                                <span v-if="selected"
                                                    class="absolute inset-y-0 left-0 flex items-center pl-3">
                                                    <CheckIcon class="h-5 w-5" />
                                                </span>
                                            </li>
                                        </ComboboxOption>
                                    </ComboboxOptions>
                                </TransitionRoot>
                            </div>
                        </Combobox>

                    </div>
                     </transition>
                 </div>
                </div>
 <!-- Upozila -->
                <div class="mb-6">
                   <div>
                    <transition
                        enter-active-class="transition-all duration-300 ease-out"
                        leave-active-class="transition-all duration-200 ease-in"
                        enter-from-class="opacity-0 transform -translate-y-4"
                        leave-to-class="opacity-0 transform -translate-y-4"
                    >  
                    <div v-if="showUpozila" class="relative">
                        <Combobox v-model="selectedUpozila" >
                            <div class="relative mt-1">
                                <div
                                    class="relative w-full cursor-default overflow-hidden rounded-lg border border-gray-300 bg-white text-left sm:text-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <MagnifyingGlassIcon class="h-5 w-5 text-gray-400" />
                                    </div>
                                    <ComboboxInput
                                        class="w-full border-none py-2 pl-10 pr-10 text-sm leading-5 text-gray-900 focus:ring-0"
                                        :displayValue="(item) => item?.name ?? ''"
                                        @change="query = $event.target.value" />
                                    <ComboboxButton class="absolute inset-y-0 right-0 flex items-center pr-2">
                                        <ChevronUpDownIcon class="h-5 w-5 text-gray-400" />
                                    </ComboboxButton>
                                </div>

                                <TransitionRoot leave="transition ease-in duration-100" leaveFrom="opacity-100"
                                    leaveTo="opacity-0" @after-leave="query = ''">
                                    <ComboboxOptions
                                        class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black/5 focus:outline-none sm:text-sm">
                                        <div v-if="filteredUpozilas.length === 0 && query !== ''"
                                            class="relative cursor-default select-none px-4 py-2 text-gray-700">
                                            Nothing found.
                                        </div>

                                        <ComboboxOption v-for="upozila in filteredUpozilas" :key="upozila.id"
                                            :value="upozila" v-slot="{ selected, active }">
                                            <li class="relative cursor-default select-none py-2 pl-10 pr-4" :class="{
                                                'bg-teal-600 text-white': active,
                                                'text-gray-900': !active,
                                            }">
                                                <span class="block truncate" :class="{ 'font-medium': selected }">
                                                    {{ upozila.name }}
                                                </span>

                                                <span v-if="selected"
                                                    class="absolute inset-y-0 left-0 flex items-center pl-3">
                                                    <CheckIcon class="h-5 w-5" />
                                                </span>
                                            </li>
                                        </ComboboxOption>
                                    </ComboboxOptions>
                                </TransitionRoot>
                            </div>
                        </Combobox>

                    </div>
                     </transition>
                 </div>
                </div>
                
            </div>
            <button class="w-full bg-primary text-white py-2 rounded-lg hover:bg-blue-700 font-medium"
                @click="getFilteredResults()">
                ফিল্টার প্রয়োগ করুন
            </button>
        </div>
    </div>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0);
    border-radius: 4px;
    transition: background-color 0.25s ease;
}

.custom-scrollbar.scrolling::-webkit-scrollbar-thumb {
    background-color: rgba(193, 193, 193, 0.9);
}

.custom-scrollbar.scrolling::-webkit-scrollbar-thumb:hover {
    background-color: rgba(161, 161, 161, 1);
}
</style>