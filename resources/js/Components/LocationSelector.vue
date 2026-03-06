<script setup>
import { ref, computed, watch } from 'vue'
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

function getZilasByDistrict(id) {
    const district = districtsData.value.find(d => d.id == id)

    if (district?.zilas) {
        filteredZilaList.value = district.zilas
    } else {
        filteredZilaList.value = allZilasData.value.filter(
            z => z.district_id == id
        )
    }

    emit('update:zilaId', '')
    emit('update:upozilaId', '')
}

function getUpozilasByZila(id) {
    const zila = allZilasData.value.find(z => z.id == id)

    filteredUpozilaList.value = zila?.upozilas || []

    emit('update:upozilaId', '')
}

watch(() => props.districtId, (val) => {
    if (val) getZilasByDistrict(val)
})

watch(() => props.zilaId, (val) => {
    if (val) getUpozilasByZila(val)
})
</script>

<template>

<div class="grid grid-cols-1 md:grid-cols-3 gap-3">
    <div >
        <InputLabel value="বিভাগ" required />
        <SelectInput class="w-full"
            :options="districtsData"
            labelKey="name"
            valueKey="id"
            defaultVal="বিভাগ নির্বাচন করুন"
            :modelValue="districtId"
            @update:modelValue="emit('update:districtId', $event)"
        />
        <InputError :message="errors?.district_id"/>
    </div>
    <div>
        <InputLabel value="জেলা" required />
        <SelectInput class="w-full"
            :options="filteredZilaList"
            labelKey="name"
            valueKey="id"
            defaultVal="জেলা নির্বাচন করুন"
            :modelValue="zilaId"
            @update:modelValue="emit('update:zilaId', $event)"
            :disabled="!districtId"
        />
        <small v-if="districtId">
        পাওয়া গেছে: {{ filteredZilaList.length }} টি জেলা
      </small>
        <InputError :message="errors?.zila_id"/>
    </div>
    <div>
        <InputLabel value="উপজেলা" required />

        <SelectInput class="w-full"
            :options="filteredUpozilaList"
            labelKey="name"
            valueKey="id"
            defaultVal="উপজেলা নির্বাচন করুন"
            :modelValue="upozilaId"
            @update:modelValue="emit('update:upozilaId', $event)"
            :disabled="!zilaId"
        />
        <small v-if="zilaId">
        পাওয়া গেছে: {{ filteredUpozilaList.length }} টি জেলা
      </small>
        <InputError :message="errors?.upozila_id"/>
    </div>

</div>
</template>