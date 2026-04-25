<script setup>
import { ref, computed, onMounted } from 'vue'
import InputLabel from '@/Components/InputLabel.vue'
import SelectInput from '@/Components/SelectInput.vue'
import InputError from '@/Components/InputError.vue'

const props = defineProps({
    districts: Object,
    zilas: Object,

    districtId: [String, Number],
    zilaId: [String, Number],
    upozilaId: [String, Number],

    errors: Object
})

const emit = defineEmits([
    'update:districtId',
    'update:zilaId',
    'update:upozilaId'
])

const districtsData = computed(() => props.districts?.data || props.districts || [])
const allZilasData = computed(() => props.zilas?.data || props.zilas || [])

const filteredZilaList = ref([])
const filteredUpozilaList = ref([])

function loadZilas(districtId) {
    const district = districtsData.value.find(d => d.id == districtId)

    if (district?.zilas) {
        filteredZilaList.value = district.zilas
    } else {
        filteredZilaList.value = allZilasData.value.filter(
            z => z.district_id == districtId
        )
    }
}

function loadUpozilas(zilaId) {
    const zila = allZilasData.value.find(z => z.id == zilaId)
    filteredUpozilaList.value = zila?.upozilas || []
}

function handleDistrictChange(val) {
    emit('update:districtId', val)
    emit('update:zilaId', '')
    emit('update:upozilaId', '')

    loadZilas(val)
    filteredUpozilaList.value = []
}

function handleZilaChange(val) {
    emit('update:zilaId', val)
    emit('update:upozilaId', '')

    loadUpozilas(val)
}

onMounted(() => {
    if (props.districtId) {
        loadZilas(props.districtId)
    }

    if (props.zilaId) {
        loadUpozilas(props.zilaId)
    }
})
</script>

<template>
<div class="grid grid-cols-1 md:grid-cols-3 gap-3">
    <div>
        <InputLabel value="বিভাগ" required />
        <SelectInput class="w-full p-3"
            :options="districtsData"
            labelKey="name"
            valueKey="id"
            defaultVal="বিভাগ নির্বাচন করুন"
            :modelValue="districtId"
            @update:modelValue="handleDistrictChange"
        />
        <InputError :message="errors?.district_id"/>
    </div>
    <div>
        <InputLabel value="জেলা" required />
        <SelectInput class="w-full p-3"
            :options="filteredZilaList"
            labelKey="name"
            valueKey="id"
            defaultVal="জেলা নির্বাচন করুন"
            :modelValue="zilaId"
            @update:modelValue="handleZilaChange"
            :disabled="!districtId"
        />
        <InputError :message="errors?.zila_id"/>
    </div>

    <div>
        <InputLabel value="উপজেলা" required />
        <SelectInput class="w-full p-3"
            :options="filteredUpozilaList"
            labelKey="name"
            valueKey="id"
            defaultVal="উপজেলা নির্বাচন করুন"
            :modelValue="upozilaId"
            @update:modelValue="(val) => emit('update:upozilaId', val)"
            :disabled="!zilaId"
        />
        <InputError :message="errors?.upozila_id"/>
    </div>

</div>
</template>