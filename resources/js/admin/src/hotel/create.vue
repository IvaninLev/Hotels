<script setup>
import {ref, onMounted, provide} from "vue";
import {VFileUpload} from 'vuetify/labs/VFileUpload'
import CountryService from "../../services/CountryService.js";
import useVuelidate from "@vuelidate/core";
import {required} from '@vuelidate/validators'
import HotelService from "../../services/HotelService.js";
import RoomTypeService from "../../services/RoomTypeService.js";
import HotelForm from "../../components/hotel/HotelForm.vue";
import RoomsForm from "../../components/hotel/RoomsForm.vue";


const props = defineProps({
    countries: {
        type: Array,
        required: true
    },
    cities: {
        type: Array,
        default: []
    },
    hotel: {
        type: Object,
        default: {}
    },
    roomTypes: {
        type: Array,
        required: true
    }
})

const countries = ref(props.countries.sort((a, b) => a.name.localeCompare(b.name)))
const cities = ref(props.cities)
const loading = ref(false)
const roomTypes = ref(props.roomTypes);

const activeTab = ref('main')

const form = ref({
    country: null,
    city: null,
    image: [],
    name: null,
    description: null,
    files: [],
    roomTypes: []
})


const v$ = useVuelidate()


const getCities = async () => {
    try {
        const response = await CountryService.getCities(form.value.country)
        cities.value = response.sort((a, b) => a.name.localeCompare(b.name))
    } catch (e) {
        console.error(e)
    }
}
const getRoomTypes = async () => {
    try {
        const response = await RoomTypeService.getRoomTypes(form.value.roomTypes)
    } catch (e) {
        console.error(e)
    }
}

const save = async () => {
    v$.value.$touch()
    if (v$.value.$invalid) {
        console.log('ошибка:', v$.value.$errors)
        return
    }

    const formData = new FormData()

    formData.append('name', form.value.name)
    formData.append('description', form.value.description)
    formData.append('country', form.value.country)
    formData.append('city', form.value.city)
    formData.append('roomTypes', JSON.stringify(form.value.roomTypes))

    let base64Images = []
    if (form.value.files.length > 0) {
        base64Images = await Promise.all(
            form.value.files.map((image) => {
                return new Promise((resolve, reject) => {
                    const reader = new FileReader()
                    reader.onload = () => {
                        resolve(reader.result)
                    }
                    reader.onerror = reject
                    reader.readAsDataURL(image)
                })
            })
        )
    }

    const allImages = form.value.image.concat(base64Images)

    allImages.forEach((image, index) => {
        formData.append(`images[${index}]`, image)
    })

    loading.value = true

    if (form.value.id) {
        formData.append('id', form.value.id)
        await HotelService.updateHotel(form.value.id, formData)
            .then(response => {
                if (response.success) {
                    window.location = '/admin/hotel'
                }
            })
            .finally(() => {
                loading.value = false
            })
    } else {

        HotelService.createHotel(formData)
            .then(roomResponse => {
                if (roomResponse.success) {
                    window.location = '/admin/hotel'
                }
            }).finally(() => {
            loading.value = false
        })

    }
}


onMounted(async () => {
    const urlParams = new URLSearchParams(window.location.search)
    const hotelId = urlParams.get('id') || window.location.pathname.split('/').pop()

    if (hotelId && hotelId !== 'create') {
        form.value.id = hotelId
    }

    form.value.name = props.hotel.name
    form.value.description = props.hotel.description
    form.value.country = props.hotel.country_id
    form.value.city = props.hotel.city_id
    form.value.image = props.hotel.hotel_images || []
})
provide('hotel-form', {
    countries,
    getCities,
    cities,
    form
})
provide('rooms-form', {
    roomTypes,
    form
})
</script>

<template>
    <main class="main">
        <nav aria-label="breadcrumb" class="d-none d-lg-block">
            <ol class="breadcrumb bg-transparent p-0 mx-3 justify-content-end">
                <li class="breadcrumb-item text-capitalize">
                    <a href="/admin/{{ route('backpack.dashboard') }}">Admin</a>
                </li>
                <li class="breadcrumb-item text-capitalize">
                    <a href="/admin/">Hotels</a>
                </li>
                <li class="breadcrumb-item text-capitalize active" aria-current="page">
                    Add
                </li>
            </ol>
        </nav>

        <!-- Форма -->
        <v-card>
            <v-card-title class="d-flex ga-2 align-end">
                <h1 class="text-capitalize mb-0">Hotels</h1>
                <p class="ms-2 mb-0" bp-section="page-subheading">Add hotel.</p>
                <p class="mb-0 ms-2" bp-section="page-subheading-back-button">
                    <small>
                        <a href="/admin/hotel" class="d-print-none font-sm">
                            <span><i class="la la-angle-double-left"></i> Back to all <span>hotels</span></span>
                        </a>
                    </small>
                </p>
            </v-card-title>

            <v-tabs v-model="activeTab">
                <v-tab value="main">Main info</v-tab>
                <v-tab value="rooms">Rooms info</v-tab>
            </v-tabs>
            <v-tabs-window v-model="activeTab">
                <v-tabs-window-item value="main">
                    <HotelForm/>
                </v-tabs-window-item>
                <v-tabs-window-item value="rooms">
                    <v-container>
                        <RoomsForm/>
                    </v-container>
                </v-tabs-window-item>
            </v-tabs-window>


            <v-card-actions class="justify-end">
                <v-btn
                    color="success"
                    variant="flat"
                    prepend-icon="mdi-content-save-outline"
                    class="me-3"
                    :loading="loading"
                    @click="save"
                >
                    <span>Save and back</span>
                </v-btn>

                <v-btn href="/admin/hotel" prepend-icon="mdi-cancel" variant="plain">
                    Cancel
                </v-btn>
            </v-card-actions>
        </v-card>
    </main>
</template>
