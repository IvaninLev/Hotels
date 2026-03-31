<script setup>
import {ref, watch} from "vue";


const props = defineProps({
    open: {
        type: Boolean,
        default: false,
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
})

const emit = defineEmits(['close', 'apply', 'clear'])

const slider = ref([3, 20])
const showMore = ref(false)
const amenities = ref([])
const searchQuery = ref('')
const priceType = ref('One')
const season = ref(null)
const foodType = ref(null)
const minRating = ref('any')

const applyFilters = () => {
    emit('apply', {
        searchQuery: searchQuery.value,
        duration: [slider.value],
        amenities: [...amenities.value],
        priceType: priceType.value,
        season: season.value,
        foodType: foodType.value,
        minRating: minRating.value,
    })
}
const clearFilters = () => {
    slider.value = [3, 20]
    showMore.value = false
    amenities.value = []
    searchQuery.value = ''
    priceType.value = 'one'
    foodType.value = null
    season.value = null
    minRating.value = 'any'
    emit('clear')

}

</script>

<template>
    <div class="sidebar" :class="{ open: props.open }">
        <div class="sidebar-content">
            <button class="close-btn" @click="emit('close')">✕</button>
            <h2>Фильтры</h2>
            <v-icon @click="emit('close')">X</v-icon>
            <div class="mt-5">
                <h4 class="mb-0 pl-2">ПОКАЗАТЬ ЦЕНУ</h4>
                <v-radio-group inline v-model="priceType">
                    <v-radio color="indigo-darken-3" label="На человека" value="one"/>
                    <v-radio color="indigo-darken-3" label="На всех" value="two"/>
                </v-radio-group>
            </div>
            <div class="mt-5">
                <h4 class="mb-0 pl-2">ПРЕДЛОЖЕНИЯ</h4>
                <v-radio-group v-model="season">
                    <v-radio color="indigo-darken-3" label="Горящие туры" value="hot"/>
                    <v-radio color="indigo-darken-3" label="Зима 2026/2027" value="winter"/>
                    <v-radio color="indigo-darken-3" label="Весна 2026" value="spring"/>
                    <v-radio color="indigo-darken-3" label="Осень 2026 " value="autumn"/>
                </v-radio-group>
            </div>
            <div>
                <h5 class="mb-0 pl-2">ПРОДОЛЖИТЕЛЬНОСТЬ ПРОБЫВАНИЯ</h5>
                <v-range-slider
                    v-model="slider"
                    thumb-color="white"
                    thumb-size="18"
                    width="300"
                    class="custom-range"
                    trackColor="#D4D4D4"
                    color="#463998"
                    track-size="2"
                    :min="1"
                    :max="20"
                    :step="1"
                />
                <div class="flex d-flex">
                    <span>От</span>
                    <input class="days mx-2" :value="slider[0]">

                    <span>До</span>
                    <input class="days mx-2" :value="slider[1]">
                    <span>ночей</span>
                </div>
            </div>
            <div class="mt-5">
                <h4 class="mb-0 pl-2">ЕДА</h4>
                <v-radio-group v-model="foodType">
                    <v-radio color="indigo-darken-3" label="Завтраки (BB)" value="BB"/>
                    <v-radio color="indigo-darken-3" label="Все включено (AI)" value="AI"/>
                    <v-radio color="indigo-darken-3" label="Ультра AI (UAI)" value="UAI"/>
                    <v-radio color="indigo-darken-3" label="Без питания (RO)" value="RO"/>
                </v-radio-group>
            </div>
            <div class="mt-5">
                <h4 class="mb-0 pl-2">МИНИМАЛЬНЫЙ РЕЙТИНГ</h4>
                <v-radio-group v-model="minRating">
                    <div class="rating-row">
                        <v-radio color="indigo-darken-3" label="от 5" value="5"/>
                        <v-icon class="rating-star" color="#EC1C24">mdi-star</v-icon>
                    </div>
                    <div class="rating-row">
                        <v-radio color="indigo-darken-3" label="от 4" value="4"/>
                        <v-icon class="rating-star" color="#EC1C24">mdi-star</v-icon>
                    </div>
                    <div class="rating-row">
                        <v-radio color="indigo-darken-3" label="от 3" value="3"/>
                        <v-icon class="rating-star" color="#EC1C24">mdi-star</v-icon>
                    </div>
                    <div class="rating-row">
                        <v-radio color="indigo-darken-3" label="любой" value="any"/>
                        <v-icon class="rating-star" color="#EC1C24">mdi-star</v-icon>
                    </div>
                </v-radio-group>
            </div>
            <div class="mt-5">
                <h4 class="mb-0 pl-2">Удобства</h4>
                <v-checkbox-group v-model="amenities">
                    <v-checkbox
                        color="indigo-darken-3"
                        label="Близко к центру"
                        value="center"
                        true-icon="mdi-radiobox-marked"
                        false-icon="mdi-radiobox-blank"
                    />

                    <v-checkbox
                        color="indigo-darken-3"
                        label="Анимации для детей"
                        value="kids"
                        true-icon="mdi-radiobox-marked"
                        false-icon="mdi-radiobox-blank"
                    />

                    <v-checkbox
                        color="indigo-darken-3"
                        label="Никаких ночных поездок"
                        value="no_night"
                        true-icon="mdi-radiobox-marked"
                        false-icon="mdi-radiobox-blank"
                    />

                    <v-checkbox
                        color="indigo-darken-3"
                        label="Рядом с аэропортом"
                        value="airport"
                        true-icon="mdi-radiobox-marked"
                        false-icon="mdi-radiobox-blank"
                    />

                    <p @click="showMore = !showMore" class="show_more" style="cursor:pointer;">
                        {{ showMore ? 'Скрыть' : 'Показать больше' }}
                    </p>

                    <v-expand-transition>
                        <div v-if="showMore">
                            <v-checkbox
                                color="indigo-darken-3"
                                label="some another facilities"
                                value="another"
                                true-icon="mdi-radiobox-marked"
                                false-icon="mdi-radiobox-blank"
                            />
                        </div>
                    </v-expand-transition>
                </v-checkbox-group>

            </div>

            <v-divider class="mt-7"></v-divider>
            <div class="flex d-flex mt-5 justify-space-between">
                <p class="text-gray font-weight-medium pt-1" style="cursor:pointer;" @click="clearFilters">Очистить</p>
                <v-btn color="black" @click="applyFilters" rounded="pill" width="170" height="40">ПРИМЕНИТЬ
                    <v-icon>mdi mdi-arrow-bottom-right</v-icon>
                </v-btn>
            </div>
        </div>
    </div>

</template>

<style scoped>
.show_more {
    font-weight: 600;
    font-size: 14px;
    margin-left: 40px;
}

.days {
    border: 2px solid #D4D4D4;
    width: 33px;
    justify-items: center;
    border-radius: 20%;
}

.sidebar {
    position: fixed;
    top: 0;
    right: -100%;
    width: 100%;
    max-width: 480px;
    height: 100vh;
    background: #fff;
    z-index: 999;
    transition: right .35s ease;
    box-shadow: -4px 0 20px rgba(0, 0, 0, 0.15);
}

.sidebar.open {
    right: 0;
}

.sidebar-content {
    padding: 24px;
    height: 100%;
    overflow-y: auto;
}


.close-btn {
    background: none;
    border: none;
    font-size: 26px;
    cursor: pointer;
    float: right;
}

.rating-row {
    display: flex;
    align-items: center;
    gap: 0;
}

.rating-row :deep(.v-label) {
    margin-right: 0;
}

.rating-row :deep(.v-selection-control__input) {
    margin-right: 0;
}

.rating-star {
    margin-left: 0;
}

.sidebar-content :deep(.v-selection-control) {
    margin-bottom: 2px;
    min-height: 0;
    padding: 0;
}

.sidebar-content :deep(.v-selection-control__wrapper) {
    margin: 7px;
    height: 20px;
}


.sidebar-content :deep(.v-input__details) {
    display: none;
}

</style>
