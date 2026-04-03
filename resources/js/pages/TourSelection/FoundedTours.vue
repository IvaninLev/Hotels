<script setup>
import {computed, onMounted, ref, watch, watchEffect} from 'vue'
import {useRoute, useRouter} from 'vue-router'
import TourService from "../../services/TourService.js";
import FilterService from "../../services/FilterService.js";
import Sidebar from "./Sidebar.vue";
import {useSearchStore} from "../../stores/useSearchStore.js";
import {useI18n} from "vue-i18n";

const {t, tm} = useI18n({useScope: 'global'})
const searchStore = useSearchStore();
const route = useRoute()
const router = useRouter()
const expand = ref(false)
const tours = computed(() => searchStore.tours)
const page = ref(1)
const isFiltered = ref(false)
const isSearched = ref(false)
const sortOptions = computed(() => {
    const options = tm('tour.sortOptions') ?? {}
    return Object.entries(options).map(([value, label]) => ({value, label}))
})
const selectedSort = ref(null)
const sort = ref(false)

watchEffect(() => {
    if (!selectedSort.value && sortOptions.value.length) {
        selectedSort.value = sortOptions.value[0]
    }
})


const totalPages = computed(() => {
    const lastPage = searchStore.toursMeta?.last_page
    return Math.max(1, Number.isFinite(lastPage) ? lastPage : 1)
})

const totalToursCount = computed(() => {
    const total = searchStore?.toursMeta.total
    return Number.isFinite(total) ? total : tours.value.length
});

watch(totalPages, (next) => {
    if (page.value > next) {
        page.value = next
    }
})

const nextPage = () => {
    if (page.value < totalPages.value) page.value++;
};
const prevPage = () => {
    if (page.value > 1) page.value--;
};
const filters = ref({
    searchQuery: '',
    duration: [3, 20],
    amenities: [],
    priceType: 'One',
    offerType: null,
    foodType: null,
    minRating: 'any',
    from: "",
    toPlace: "",
    flightDate: "",
    tourists: null
})


const currentLabel = computed(() => {
    return route.meta?.breadcrumb || route.name || route.path
})

const goHome = () => {
    router.push('/')
}


const getSeasonLabel = (range) => {
    if (!range) return ''

    const [d, m, y] = range.split(' - ')[0].split('.')
    const month = parseInt(m)

    const seasons = {
        зима: [12, 1, 2],
        весна: [3, 4, 5],
        лето: [6, 7, 8],
        осень: [9, 10, 11]
    }

    const season = Object.keys(seasons).find(s => seasons[s].includes(month))

    return `${season} ${y}`
}


const fetchTours = async () => {
    if (isFiltered.value) {
        searchStore.setTours(await FilterService.getFilteredTours({
            ...filters.value,
            sort: selectedSort.value?.value,
            page: page.value
        }))
        return
    }
    if (isSearched.value) {
        searchStore.setTours(await FilterService.getSearchedTours({
            ...filters.value,
            sort: selectedSort.value?.value,
            page: page.value
        }))
        return
    }
    searchStore.setTours(await TourService.getToursPage(page.value, selectedSort.value?.value))
}

const setPageAndFetch = async (nextPage) => {
    if (page.value === nextPage) {
        await fetchTours()
        return
    }
    page.value = nextPage
}
const selectSort = async (option) => {
    selectedSort.value = option
    sort.value = false
    await setPageAndFetch(1)
}


onMounted(async () => {
    if (Object.keys(route.query || {}).length) {
        filters.value = {
            ...filters.value,
            ...route.query,
        }
        isSearched.value = true
        isFiltered.value = false
    }
    await fetchTours()
})

watch(
    () => route.query,
    async (query) => {
        const hasQuery = Object.keys(query || {}).length > 0
        if (hasQuery) {
            filters.value = {
                ...filters.value,
                ...query
            }
            const matchedSort = sortOptions.value.find(o => o.value === query.sort)
            selectedSort.value = matchedSort ?? sortOptions.value?.[0]
            isSearched.value = true
            isFiltered.value = false
            await setPageAndFetch(1)
        } else {
            isSearched.value = false
            await setPageAndFetch(1)
        }
    }
)
const applyFilters = async (next) => {
    filters.value = {
        ...filters.value,
        ...next,
    }
    isFiltered.value = true
    await setPageAndFetch(1)
    expand.value = false
}

const clearFilters = async () => {
    filters.value = {
        searchQuery: '',
        duration: [3, 20],
        amenities: [],
        priceType: 'One',
        offerType: null,
        foodType: null,
        minRating: 'any',
        from: "",
        toPlace: "",
        flightDate: "",
        tourists: null
    }
    isFiltered.value = false
    await setPageAndFetch(1)
}

watch(page, async () => {
    await fetchTours()
})

</script>

<template>
    <section class="foundedOptions">
        <v-container>
            <div class="breadcrumbs">
                <span class="crumb" @click="goHome">{{ t('nav.home') }}</span>
                <span class="divider">/</span>
                <span class="crumb active">{{ currentLabel }}</span>
            </div>
            <v-card-title class="flex d-flex">
                <h2>{{ t('tour.foundTitle') }}</h2>
                <v-card-subtitle class="pt-5">({{ t('tour.offers', {count: totalToursCount}) }})</v-card-subtitle>
            </v-card-title>
            <div class="d-flex justify-space-between align-center w-100">

                <div class="d-flex pl-3x">
                    <v-btn variant="text" @click="sort = !sort">
                        <v-icon icon="mdi-sort-variant" class="mr-2"></v-icon>
                        <v-card-subtitle class="variant" \>
                            {{ t('tour.sort') }}: <strong
                            class="text-black">{{ selectedSort?.label ?? sortOptions[0]?.label }}</strong>
                        </v-card-subtitle>
                    </v-btn>
                </div>
                <div class="d-flex pr-16">
                    <v-btn variant="text" class="d-flex align-center">
                        <v-icon start color="base-gray">mdi-earth</v-icon>
                        <span class="text-button font-weight-medium">Карта</span>
                    </v-btn>

                    <v-btn variant="outlined" class="d-flex align-center" rounded="pill">
                        <v-icon start color="base-gray">mdi-tune-variant</v-icon>
                        <span class="text-button font-weight-medium" @click="expand = !expand">Фильтры</span>
                    </v-btn>
                </div>

            </div>

            <div>
                <v-expand-transition>
                    <v-sheet v-if="sort" width="260px" rounded="xl" position="absolute" style="z-index: 2">
                        <v-list density="compact" rounded="xl">
                            <v-list-item
                                v-for="option in sortOptions"
                                :key="option.value"
                                @click="selectSort(option)"
                            >
                                <v-list-item-title class="mb-3">{{ option.label }}</v-list-item-title>
                                <v-divider></v-divider>
                            </v-list-item>
                        </v-list>
                    </v-sheet>
                </v-expand-transition>
                <v-sheet
                    v-for="item in tours"
                    :key="item.id"
                    class="d-flex align-center justify-space-between tours"
                    width="1120"
                    height="280"
                    rounded="xl"
                    elevation="2"
                >

                    <v-img
                        :src="item.image"
                        height="100%"
                        min-width="376px"
                        max-width="376px"
                        class="image"
                        cover
                    />

                    <div class=" pa-4" style="max-width: 500px">
                        <div class="mb-2">
                            <div class="text-caption text-grey-darken-1">{{ item.country }}, {{ item?.city }}</div>
                            <h3 class="text-h5 font-weight-bold mb-5 w75">{{ item.name }}</h3>
                        </div>

                        <div class="d-flex align-center mb-3">
                            <v-rating
                                :model-value="parseFloat(item.hotel?.rating) || 0"
                                color="red"
                                active-color="red"
                                density="compact"
                                size="small"
                                readonly
                                half-increments
                            ></v-rating>
                        </div>

                        <div class="d-flex align-center mb-3">
                            <v-chip color="purple" variant="flat" size="small" class="mr-2">{{
                                    item.hotel?.rating
                                }}
                            </v-chip>
                            <span class="text-body-2">отзывов</span>
                        </div>

                        <div class="mt-9">
                            <div class="d-flex align-center mb-2">
                                <v-icon size="small" class="mr-2">mdi-calendar</v-icon>
                                <span class="text-body-2">{{ item.date }} ({{ item.days }} {{ t('tour.days') }})</span>
                            </div>
                            <div>
                                <v-icon size="small" class="mr-2">mdi-silverware-fork-knife</v-icon>
                                <span class="text-body-2">{{ item?.hotel?.nutrition.find(n => n.is_base)?.name }}</span>
                            </div>

                        </div>


                    </div>
                    <div class="mt-auto mb-10 pl-10">
                        <div
                            v-for="f in (item.hotel?.features.slice(0,4) )"
                            :key="f.id"
                            class="d-flex align-center mb-1"
                        >
                            <v-icon size="small" color="purple" class="mr-2">mdi-check-bold</v-icon>
                            <span class="text-body-2">
                                {{ f.name }} {{ f.value }}
                            </span>
                        </div>
                    </div>

                    <v-divider class="ml-10" vertical></v-divider>

                    <div class="right-section pa-4 d-flex flex-column align-end justify-space-between"
                         style="height: 100%;">
                        <v-chip color="secondary" variant="outlined">{{ getSeasonLabel(item.season) }}

                        </v-chip>

                        <div class="">
                            <div class="flex d-flex text-right">
                                <div class="text-h4 font-weight-bold mb-1">{{ item.base_price }}$</div>
                                <div class="text-caption text-grey pt-4">{{ t('tour.priceSuffix') }}</div>
                            </div>
                            <v-btn
                                color="base-red"
                                class="text-white"
                                rounded="pill"
                                size="large"
                                :to="`/tour/${item.id}`"
                                block
                            >
                                {{ t('tour.readMore') }}
                                <v-icon end>mdi-arrow-bottom-right</v-icon>
                            </v-btn>
                        </div>
                    </div>

                </v-sheet>


            </div>
            <div class="custom-pagination">
                <button v-if="page > 1" class="nav-btn" @click="prevPage">
                    <v-icon> mdi-chevron-left</v-icon>
                </button>
                <div class="page-indicator">{{ page }}</div>
                <span class="page-total">из {{ totalPages }}</span>
                <button class="nav-btn" @click="nextPage">
                    <v-icon>mdi-chevron-right</v-icon>
                </button>
            </div>
        </v-container>
        <div
            v-if="expand"
            class="overlay"
            @click="expand = false"
        ></div>
        <Sidebar
            :open="expand"
            :filters="filters"
            @close="expand = false"
            @apply="applyFilters"
            @clear="clearFilters"
        />
    </section>
</template>

<style scoped>
.custom-pagination {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    margin-top: 30px;
}

.page-indicator {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 24px;
    border: 1px solid #E0E0E0;
    border-radius: 20px;
    font-size: 16px;
    color: #333;
}

.page-total {
    font-size: 16px;
    color: #888;
    margin: 0 8px;
}

.nav-btn {
    width: 32px;
    height: 32px;
    border: 1px solid #E0E0E0;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    cursor: pointer;
    transition: all 0.2s ease;
}


.tours {
    border: gray solid 1px;
    margin-bottom: 28px;
}

.image {
    border-radius: 24px 24px 0 0;
    overflow: hidden;
}


.foundedOptions {
    height: auto;
}

.breadcrumbs {
    font-size: 0.9rem;
    color: #555;
    margin: 16px 0;
}

.crumb {
    cursor: pointer;
    color: #ec1c24;
}

.crumb.active {
    color: #333;
    cursor: default;
}

.divider {
    margin: 0 8px;
    color: #999;
}
</style>
