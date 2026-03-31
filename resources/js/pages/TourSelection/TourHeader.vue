<script setup>
import unsplashImg from '../../../src/images/unsplash.svg'
import {computed, onMounted, ref, watch} from "vue";
import {useSearchStore} from "../../stores/useSearchStore.js";
import FilterService from "../../services/FilterService.js";
import {useRoute, useRouter} from "vue-router";

const search = useSearchStore();
const route = useRoute()
const router = useRouter()
const selectingDate = ref(null);
const currentMonth = ref(new Date().toISOString().slice(0, 7))
const dateRange = ref([3, 14])
const calendar = ref(false)
const nights = ref(false)
const dates = ref([])
const durationRange = ref([3, 14])

const filters = ref({
    searchQuery: '',
    from: "",
    toPlace: "",
    flightDate: "",
    duration: null,
    tourists: null
})

const daysDisplay = (computed(() => {
    if (durationRange.value[0] === durationRange.value[1]) {
        return `${durationRange.value[0]}`
    } else {
        return `${durationRange.value[0]}-${durationRange.value[1]}`
    }
}))
const durationDays = (computed(() => {
    const days = []
    for (let i = 1; i <= 30; i++) {
        days.push(i)
    }
    return days
}))

const selectionDurationDays = (day) => {
    if (!selectingDate.value) {
        dateRange.value = [day, day]
        selectingDate.value = day
    } else {
        const start = dateRange.value[0]
        const end = day
        dateRange.value = start <= end ? [start, end] : [end, start]
        selectingDate.value = null
    }
}

const isDayInRange = (day) => {
    const [min, max] = dateRange.value
    return day >= min && day <= max
}

const isDayEdge = (day) => {
    return day === dateRange.value[0] || day === dateRange.value[1]
}


const handleSearch = async () => {
    await router.push({
        name: 'TourSelection',
        query: {
            from: filters.value.from,
            toPlace: filters.value.toPlace,
            flightDate: filters.value.flightDate,
            duration: filters.value.duration,
            tourists: filters.value.tourists,
        },
    });
};

const parseMonth = (value) => {
    const [y, m] = value.split("-").map(Number);
    return {year: y, month: m}
}

const formatMonth = (value) => {
    let year, month
    if (typeof value === 'string') ({year, month} = parseMonth(value)); else ({year, month} = value)
    const d = new Date(year, month)
    return d.toLocaleString('ru-RU', {year: "numeric", month: "long"})
}

const currentMonthParts = computed(() => parseMonth(currentMonth.value));
const nextMonthParts = computed(() => {
    const {year, month} = currentMonthParts.value;
    const d = new Date(year, month - 1, 1);
    d.setMonth(d.getMonth() + 1);
    return {year: d.getFullYear(), month: d.getMonth() + 1};
});

const nextMonth = computed(() => {
    const d = new Date(currentMonthParts.value.year, currentMonthParts.value.month - 1, 1);
    d.setMonth(d.getMonth() + 1);
    return `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, "0")}`
})

const toPrevMonth = () => {
    const {year, month} = currentMonthParts.value;
    const d = new Date(year, month - 1, 1)
    d.setMonth(d.getMonth() - 1)
    currentMonth.value = `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, "0")}`
}
const toNextMonth = () => {
    const {year, month} = currentMonthParts.value;
    const d = new Date(year, month - 1, 1)
    d.setMonth(d.getMonth() + 1)
    currentMonth.value = `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, "0")}`
}


const selectDate = () => {
    if (!dates.value || dates.value.length === 0) return;
    const d = new Date(dates.value[0])
    if (Number.isNaN(d.getTime())) return;

    const year = d.getFullYear()
    const month = String(d.getMonth() + 1).padStart(2, '0')
    const day = String(d.getDate()).padStart(2, '0')

    filters.value.flightDate = `${year}-${month}-${day}`
    calendar.value = false
}

const selectNights = () => {
    filters.value.duration = daysDisplay.value
    nights.value = false
}

onMounted(async () => {
    const saved = await FilterService.getSearchedTours()
    if (saved && !Array.isArray(saved)) {
        search.value = {
            ...search.value,
            ...saved,
        }
    }
})

watch(
    () => route.query,
    async (query) => {

        filters.value = {
            ...filters.value,
            ...query,
        }

    },
    {deep: true, immediate: true}
)
</script>

<template>
    <section class="TourHeaderLayout">
        <v-container
            fluid
            class="d-flex flex-column align-center justify-center text-center pa-0"
            min-height="100vh"
        >
            <v-img :src="unsplashImg" align="center" cover width="100%">
                <div class="text-white mb-6 w-75 mt-16">
                    <h1 class="text-hero-heading font-weight-bold mb-2">подбор тура</h1>
                    <h2 class="text-h4 pl">Идеальное путешествие начинается здесь</h2>
                </div>
                <v-card class="rounded-pill mt-16" width="930">
                    <v-container class="pa-0">

                        <v-row no-gutters justify="center" align="center" class="pa-3 pb-2">
                            <v-col cols="12" md="2" class="pl-4">
                                <v-text-field
                                    bg-color="transparent"
                                    base-color="transparent"
                                    variant="plain"
                                    v-model="filters.from"
                                    density="compact"
                                    label="Откуда"
                                    class=" border-e-sm"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field
                                    bg-color="transparent"
                                    base-color="transparent"
                                    variant="plain"
                                    density="compact"
                                    v-model="filters.toPlace"
                                    label="Куда"
                                    class=" px-1 border-e-sm"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field
                                    bg-color="transparent"
                                    base-color="transparent"
                                    variant="plain"
                                    density="compact"
                                    v-model="filters.flightDate"
                                    label="Вылет"
                                    readonly
                                    @click="calendar = !calendar"
                                    class=" px-1 border-e-sm"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field
                                    bg-color="transparent"
                                    base-color="transparent"
                                    variant="plain"
                                    density="compact"
                                    @click="nights = !nights"
                                    readonly
                                    v-model="filters.duration"
                                    label="На сколько"
                                    class=" px-1 border-e-sm"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field
                                    bg-color="transparent"
                                    base-color="transparent"
                                    variant="plain"
                                    density="compact"
                                    label="Туристы"
                                    v-model="filters.tourists"
                                    class=" px-1 border-e-sm"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="2" class="d-flex align-center ">
                                <v-btn color="base-red" @click="handleSearch" class="text-white rounded-pill mb-3 "
                                       block>
                                    ПОДОБРАТЬ
                                    <v-icon icon="mdi-arrow-bottom-right"></v-icon>
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card>
            </v-img>
        </v-container>

        <v-expand-transition>
            <div v-if="calendar" class="calendar-box">
                <div class="calendar-top justify-space-between">
                    <v-icon class="cal-nav" @click="toPrevMonth"> mdi-chevron-left</v-icon>
                    <v-icon class="cal-nav" @click="toNextMonth"> mdi-chevron-right</v-icon>
                </div>
                <div class="d-flex">
                    <div class="calendr-month">
                        <div class="calendar-title">{{ formatMonth(currentMonth) }}</div>
                        <v-date-picker-month
                            v-model="dates"
                            :month="currentMonthParts.month"
                            :year="currentMonthParts.year"
                            #day="{props, item}"
                        >
                            <div>
                                <v-btn
                                    v-bind="props" dep-day
                                    :variant="item.isSelected ? 'outlined' : 'text'"
                                    :color="item.isSelected ? 'primary' : undefined"
                                    class="day-btn"
                                    style="flex-direction: column;"

                                >
                                    <div>
                                        <div>{{ item.localized }}</div>
                                    </div>
                                </v-btn>
                            </div>
                        </v-date-picker-month>
                    </div>
                    <div class="calendr-month">
                        <div class="calendar-title">{{ formatMonth(nextMonth) }}</div>
                        <v-date-picker-month
                            style="border-color: blue;"
                            color="transparent"
                            v-model="dates"
                            :month="nextMonthParts.month"
                            :year="nextMonthParts.year"
                            #day="{item,props}"
                        >
                            <div>
                                <v-btn
                                    v-bind="props"
                                    :variant="item.isSelected ? 'outlined' : 'text'"
                                    :color="item.isSelected ? 'primary' : undefined"
                                    class="day-btn"
                                >
                                    <div>
                                        <div>{{ item.localized }}</div>
                                    </div>
                                </v-btn>
                            </div>
                        </v-date-picker-month>
                    </div>
                </div>
                <v-divider class="mt-5"></v-divider>
                <div class="calendar-footer">
                    <v-btn @click="selectDate()" class="apply-btn">выбрать
                        <v-icon> mdi-arrow-bottom-right</v-icon>
                    </v-btn>
                </div>
            </div>
        </v-expand-transition>

        <v-expand-transition>
            <div v-if="nights" class="days-box">
                <div class="days-content">
                    <div class="days-grid-container">
                        <div class="day">
                            <v-btn
                                v-for="day in durationDays"
                                :key="day"
                                :variant="isDayEdge(day) ? 'outlined' : isDayInRange(day) ? 'tonal' : 'text'"
                                :color="isDayInRange(day) ? 'primary' : undefined"
                                class="day-btn"
                                @click="selectionDurationDays(day)"
                            >
                                {{ day }}
                            </v-btn>
                        </div>
                    </div>
                </div>

                <v-divider class="mt-5"></v-divider>
                <div class="calendar-footer">
                    <v-btn @click="selectNights()" class="apply-btn">выбрать
                        <v-icon> mdi-arrow-bottom-right</v-icon>
                    </v-btn>
                </div>
            </div>
        </v-expand-transition>

    </section>
</template>

<style scoped>
.apply-btn {
    margin-left: 70px;
    width: 144px;
    border-radius: 100px;
    background-color: black;
    color: white;
    height: 40px;
    border-top: black;
}

.calendar-title {
    text-align: center;
    font-weight: 600;
    text-transform: capitalize;
}

.day-btn.v-btn--variant-outlined {
    background-color: transparent;
    border-color: #463998;
    border-width: 2px;
    border-radius: 10px;
    height: 44px;
    width: 44px;
}

.calendar-box {
    position: absolute;
    background: #fff;
    border-radius: 15px;
    padding: 20px;
    z-index: 20;
    transform: translateY(-335px) translateX(350px);
    width: 740px;
}

.days-box {
    position: absolute;
    background: #fff;
    border-radius: 15px;
    padding: 20px;
    z-index: 20;
    transform: translateY(-335px) translateX(680px);
    width: 520px;
    max-height: 600px;
    overflow-y: auto;
}

.days-content {
    padding: 10px;
}


.day-number-btn.v-btn--variant-outlined {
    border-width: 2px;
    border-color: #463998;
}

.calendar-top {
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.calendar-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 22px;
}
</style>
