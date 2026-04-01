<script setup>
import midnightImg from '../../../src/images/midnight.svg'
import {computed, onMounted, ref} from "vue";
import { useI18n } from "vue-i18n";
import FilterService from "../../services/FilterService.js";
import router from "../../router/index.js";

const calendar = ref(false)
const nights = ref(false)
const dates = ref([])
const currentMonth = ref(new Date().toISOString().slice(0, 7))
const durationRange = ref([3, 14])
const selectingDate = ref(null)


const search = ref({
    from: '',
    toPlace: '',
    flightDate: '',
    duration: null,
    tourists: null,
})

const { t } = useI18n({ useScope: 'global' })

const durationDisplay = computed(() => {
    if (durationRange.value[0] === durationRange.value[1]) {
        return `${durationRange.value[0]} `
    }
    return `${durationRange.value[0]}-${durationRange.value[1]}`
})

const durationDays = computed(() => {
    const days = []
    for (let i = 1; i <= 30; i++) {
        days.push(i)
    }
    return days
})
const selectDurationDay = (day) => {
    if (!selectingDate.value) {
        durationRange.value = [day, day]
        selectingDate.value = day
    } else {
        const start = selectingDate.value
        const end = day
        durationRange.value = start <= end ? [start, end] : [end, start]
        selectingDate.value = null
    }
}

const isDayInRange = (day) => {
    const [min, max] = durationRange.value
    return day >= min && day <= max
}

const isDayEdge = (day) => {
    return day === durationRange.value[0] || day === durationRange.value[1]
}

const handleSearch = async () => {
    await router.push({
        name: 'TourSelection',
        query: {
            from: search.value.from,
            toPlace: search.value.toPlace,
            flightDate: search.value.flightDate,
            duration: search.value.duration,
            tourists: search.value.tourists,
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

    search.value.flightDate = `${year}-${month}-${day}`
    calendar.value = false
}

const selectNights = () => {
    search.value.duration = durationDisplay.value
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
</script>

<template>
    <section class="dreamTravel">
        <v-container
            fluid
            class="d-flex flex-column align-center justify-center text-center pa-0"
            min-height="100vh"
        >
            <v-img :src="midnightImg" align="center" cover width="100%">
                <div class="text-white mb-6 w-75 mt-16">
                    <h1 class="text-hero-heading font-weight-bold mb-2">{{ t('home.heroTitle') }}</h1>
                    <h2 class="text-h6">{{ t('home.heroSubtitle') }}</h2>
                </div>
                <v-card class="rounded-pill mt-16" width="930">
                    <v-container class="pa-0">
                        <v-row no-gutters justify="center" align="center" class="pa-3 pb-2">
                            <v-col cols="12" md="2" class="pl-4">
                                <v-text-field
                                    v-model="search.from"
                                    bg-color="transparent"
                                    base-color="transparent"
                                    variant="plain"
                                    density="compact"
                                    :label="t('home.from')"
                                    class="border-e-sm"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field
                                    v-model="search.toPlace"
                                    bg-color="transparent"
                                    base-color="transparent"
                                    variant="plain"
                                    density="compact"
                                    :label="t('home.to')"
                                    class="px-1 border-e-sm"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field
                                    v-model="search.flightDate"
                                    bg-color="transparent"
                                    base-color="transparent"
                                    variant="plain"
                                    density="compact"
                                    :label="t('home.departure')"
                                    class="px-1 border-e-sm"
                                    readonly
                                    @click="calendar = !calendar"
                                    style="cursor: pointer"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field
                                    v-model="search.duration"
                                    bg-color="transparent"
                                    base-color="transparent"
                                    variant="plain"
                                    density="compact"
                                    :label="t('home.duration')"
                                    class="px-1 border-e-sm"
                                    readonly
                                    @click="nights = !nights"
                                    style="cursor: pointer"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field
                                    v-model="search.tourists"
                                    bg-color="transparent"
                                    base-color="transparent"
                                    variant="plain"
                                    type="number"
                                    density="compact"
                                    :label="t('home.tourists')"
                                    class="px-1 border-e-sm"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="2" class="d-flex align-center">
                                <v-btn
                                    color="base-red"
                                    @click="handleSearch"
                                    class="text-white rounded-pill mb-3"
                                    block
                                >
                                    {{ t('home.pick') }}
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
                                    v-bind="props" dep-day
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
                    <v-btn @click="selectDate()" class="apply-btn">{{ t('home.pick') }}
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
                                @click="selectDurationDay(day)"
                            >
                                {{ day }}
                            </v-btn>
                        </div>
                    </div>
                </div>

                <v-divider class="mt-5"></v-divider>
                <div class="calendar-footer">
                    <v-btn @click="selectNights()" class="apply-btn">{{ t('home.pick') }}
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
