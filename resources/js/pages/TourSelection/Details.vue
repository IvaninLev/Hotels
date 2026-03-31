<script setup>
import router from "../../router/index.js";
import {computed, onMounted, ref, watch} from "vue";
import {useRoute} from "vue-router";
import axios from "axios";
import TourService from "../../services/TourService.js";
import BookingService from "../../services/BookingService.js";
import {useSearchStore} from "../../stores/useSearchStore.js";
import SuccessModal from "../../components/modals/SuccessModal.vue";

const route = useRoute();
const tours = ref([]);
const searchStore = useSearchStore()
const dates = ref([])
const currentMonth = ref(new Date().toISOString().slice(0, 7))
const adults = ref(1);
const children = ref(0);
const selectedRoom = ref(null);
const selectedNutrition = ref(null);
const selectedDeparture = ref(null);
const selectedSchedule = ref(null);
const selectedDate = ref(null);
const activeMenu = ref(null);
const totalTourists = computed(() => adults.value + children.value);
const submitting = ref(false)
const success = ref(false)



const currency = '$';
const calendarOffers = computed(() => {
    const base = Number(tours.value?.[0]?.base_price ?? 0);
    const baseNights = Number(tours.value?.[0]?.tour_departures?.[0]?.night_count ?? 1);
    const pricePerNight = baseNights > 0 ? base / baseNights : base;
    const options = [10, 12, 17, 20];

    return options.map((nights) => ({
        nights,
        price: Math.round(nights * pricePerNight),
    }));
});
const toggleMenu = (name) => {
    activeMenu.value = activeMenu.value === name ? null : name;
}
const monthNames = [
    "января", "февраля", "марта", "апреля", "мая", "июня",
    "июля", "августа", "сентября", "октября", "ноября", "декабря"
];
const goHome = () => router.push("/");
const goTours = () => router.push("/tour-selection");

const filters = ref({
    slider: [3, 20],
    showMore: false,
    amenities: [],
    searchQuery: '',
    priceType: 'One',
    offerType: null,
    foodType: null,
    minRating: 'any',
})
const currentMonthParts = computed(() => parseMonth(currentMonth.value));
const nextMonthParts = computed(() => {
    const {year, month} = currentMonthParts.value;
    const d = new Date(year, month - 1, 1);
    d.setMonth(d.getMonth() + 1);
    return {year: d.getFullYear(), month: d.getMonth() + 1};
});

const currentMonthLabel = computed(() => formatMonth(currentMonthParts.value));
const nextMonthLabel = computed(() => formatMonth(nextMonthParts.value));

const nextMonth = computed(() => {
    const [y, m] = currentMonth.value.split('-').map(Number);
    const d = new Date(y, m);
    d.setMonth(d.getMonth());
    return `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}`
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

const normalizeYmd = (val) => {
    if (!val) return null;

    const d = val instanceof Date ? val : new Date(val);
    if (!d) return null;

    const y = d.getFullYear();
    const m = String(d.getMonth() + 1).padStart(2, "0");
    const day = String(d.getDate()).padStart(2, "0");

    return `${y}-${m}-${day}`;
}

const depDatesSet = computed(() => {
    const deps = tours.value?.[0].tour_departures ?? []
    return new Set(
        deps.map((dep) => normalizeYmd(dep.departure_date))
            .filter(Boolean)
    );
})

const allowed = (val) => {
    const ymd = normalizeYmd(val);
    return ymd ? depDatesSet.value.has(ymd) : false
}


const toDate = (value) => {
    if (!value) return null;
    const raw = String(value);
    const normalized = raw.includes("T") ? raw : raw.replace(" ", "T");
    const parsed = new Date(normalized);
    return Number.isNaN(parsed.getTime()) ? null : parsed;
};

const parseMonth = (value) => {
    const [y, m] = value.split("-").map(Number);
    return {year: y, month: m}
}
const formatMonth = (value) => {
    let year
    let month
    if (typeof (value) === "string") {
        ({year, month} = parseMonth(value));
    } else {
        year = value.year
        month = value.month
    }
    const d = new Date(year, month)
    return d.toLocaleString('ru-RU', {year: "numeric", month: "long"})
}
const formatTime = (value) => {
    return value.slice(0, 5)

};

function formatDateRange(dateString) {
    if (!dateString) return "";
    const parts = dateString.split("-").map(s => s.trim());
    if (parts.length !== 2) return dateString;
    const [startStr, endStr] = parts;

    const [d1, m1, y1] = startStr.split(".").map(Number);
    const [d2, m2, y2] = endStr.split(".").map(Number);

    const month1 = monthNames[m1 - 1];
    const month2 = monthNames[m2 - 1];

    if (m1 === m2 && y1 === y2) {
        return `${d1} ${month1} – ${d2} ${month1} ${y1}`;
    }
    if (y1 === y2) {
        return `${d1} ${month1} – ${d2} ${month2} ${y1}`;
    }
    return `${d1} ${month1} ${y1} – ${d2} ${month2} ${y2}`;
}

const formattedSelectedDates = computed(() => {
    if (!dates.value || dates.value.length === 0) return tours.value?.[0].date || ''

    const selectedDate = dates.value[0]
    const ymd = normalizeYmd(selectedDate);
    const dep = tours.value?.[0]?.tour_departures.find(
        d => normalizeYmd(d.departure_date) === ymd
    )
    if (dep && dep.dates) {
        return dep.dates
    }
    return tours.value?.value[0]?.date || ''
})

const formatDate = (value) => {
    const date = toDate(value);
    if (!date) return "";

    const day = date.getDate();
    const month = monthNames[date.getMonth()];
    const year = date.getFullYear();

    return `${day} ${month} ${year}`;

}

const getExtraPrice = (item) => {
    if (!item) return 0;

    return Number(item.price_modifier || item.price_per_person || item.price || 0)
}

const baseTourPrice = computed(() => Number(tours.value?.[0]?.base_price ?? 0))
const dateExtraPrice = computed(() => {
    if (selectedDate.value) return getExtraPrice(selectedDate.value)
    if (dates?.value.length > 0) {
        const ymd = normalizeYmd(dates.value[0])
        const dep = tours.value?.[0].tour_departures.find(d => normalizeYmd(d.departure_date) === ymd)
        return getExtraPrice(dep)
    }
    return 0
})
const roomExtraPrice = computed(() => {
    if (selectedRoom.value) return getExtraPrice(selectedRoom.value)
    return 0
})

const nutritionExtraPrice = computed(() => {
    if (selectedNutrition.value) return getExtraPrice(selectedNutrition.value)
    return 0
})

const finalPrice = computed(() => {
    const pricePerPerson =
        roomExtraPrice.value +
        dateExtraPrice.value +
        baseTourPrice.value +
        nutritionExtraPrice.value;
    return pricePerPerson * totalTourists.value

});
const selectRoom = (room) => {
    selectedRoom.value = room;
    activeMenu.value = null;
}

const selectDeparture = (dep) => {
    selectedDeparture.value = dep;
    activeMenu.value = null;
}

const selectNutrition = (nut) => {
    selectedNutrition.value = nut;
    activeMenu.value = null;
}

const selectTourists = () => {
    activeMenu.value = null;
};

const selectFlightSchedule = (sched) => {
    selectedSchedule.value = sched;
    activeMenu.value = null;
}

const selectDate = (date) => {
    selectedDate.value = date;
    activeMenu.value = null;
}
const incrementAdults = () => adults.value++;
const decrementAdults = () => {
    if (adults.value > 1) adults.value--;
};
const incrementChildren = () => children.value++;
const decrementChildren = () => {
    if (children.value > 0) children.value--;
};


const depPriceDate = (val) => {
    const ymd = normalizeYmd(val);
    if (!ymd) return null;

    const base = Number(tours.value?.[0].base_price)
    const dep = tours.value?.[0]?.tour_departures.find(
        (d) => normalizeYmd(d.departure_date) === ymd,
    )
    if (!dep) return null;

    const extra = Number(dep.extra_price ?? dep.price ?? 0)
    return base + extra;
}

const currentDeparture = computed(() => {
    if (selectedDeparture.value) {
        return selectedDeparture.value;
    }

    if (dates.value && dates.value.length > 0) {
        const ymd = normalizeYmd(dates.value[0]);
        const dep = tours.value?.[0]?.tour_departures.find(
            d => normalizeYmd(d.departure_date) === ymd
        );
        if (dep) return dep;
    }

    return tours.value?.[0]?.tour_departures?.[0];
});

const submitBooking = async () => {
    const tour = tours.value?.[0];
    if (!tour) return;

    const dep = selectedDeparture.value
        ? tour.tour_departures.find(d => normalizeYmd(d.departure_date) === normalizeYmd(dates.value[0]))
        : tour.tour_departures?.[0]

    const payload = {
        tour_id: tour.id,
        hotel_id: tour.hotel.id,
        tour_departure_id: dep.id,
        room_type_id: selectedRoom.value?.id ?? tour?.hotel?.roomTypes.find(t => t.is_base)?.id ?? null,
        nutrition_id: selectedNutrition.value?.id ?? tour?.hotel?.nutrition.find(n => n.is_base)?.id ?? null,
        adults: adults.value,
        children: children.value,
        start_date: normalizeYmd(dep?.departure_date ?? dates.value?.[0] ?? null),
        end_date: normalizeYmd(dep?.return_date ?? null),
        nights: dep?.night_count ?? null,
        total_price: finalPrice.value,
    };

    submitting.value = true;
    try {
        await BookingService.sentBooking(payload);
        activeMenu.value = null;
    } finally {
        submitting.value = false;
        success.value = true
        window.location.href = '/tour-selection'
    }
}

onMounted(async () => {
    const tourId = route.params.id
    const tourData = await TourService.getTour(tourId);
    tours.value = [tourData]

});


</script>

<template>
    <section class="TourDetails">
        <v-container v-for="items in tours" :key="items.id">

            <div class="breadcrumbs">
                <span class="crumb" @click="goHome">Главная</span>
                <span class="divider">/</span>
                <span class="crumb" @click="goTours">Выбор туров</span>
                <span class="divider">/</span>
                <span class="crumb active">{{ items.name }}</span>
            </div>

            <div class="top-block">
                <div class="left-column">
                    <v-img cover :src="items.hotel.main_image" class="main_image"/>

                    <div class="sub_gallery">
                        <v-img
                            v-for="(img, i) in (items.hotel?.images ?? [])"
                            :key="i"
                            :src="'/storage/' + img"
                            cover
                            class="sub_image"
                        />
                    </div>
                </div>

                <v-expand-x-transition>
                    <v-sheet v-if="activeMenu === 'sched' && currentDeparture" class="schedule px-6 py-4" rounded="xl">
                        <div class="flight-section mb-8">
                            <h4 class="text-uppercase text-grey-darken-1 mb-4">Отправление</h4>

                            <div class="flight-row d-flex">
                                <div class="time-col font-weight-bold text-h6">
                                    {{ formatTime(currentDeparture.departure_time) }}
                                </div>
                                <div class="path-col mx-4">
                                    <v-icon size="small" class="plane-icon">mdi-airplane</v-icon>
                                    <div class="dot"></div>
                                    <div class="line"></div>
                                </div>
                                <div class="info-col">
                                    <div class="font-weight-bold">
                                        {{
                                            currentDeparture.airport.city.name
                                        }},{{ currentDeparture.airport.airport_name }}
                                    </div>
                                    <div class="text-caption text-grey">
                                        {{ formatDate(currentDeparture.departure_date) }}
                                    </div>
                                    <div class="text-caption text-grey-lighten-1 mt-1">Enter Air,
                                        {{ currentDeparture.airport.id }}
                                    </div>
                                </div>
                            </div>

                            <div class="flight-row d-flex mt-n1">
                                <div class="time-col font-weight-bold text-h6">
                                    {{ formatTime(currentDeparture.arrival_time) }}
                                </div>
                                <div class="path-col mx-4">
                                    <v-icon size="small" class="plane-icon">mdi-airplane</v-icon>
                                    <div class="dot"></div>
                                </div>
                                <div class="info-col">
                                    <div class="font-weight-bold">{{ currentDeparture.return_city_name }},
                                        {{ currentDeparture.return_airport.airport_name }}
                                    </div>
                                    <div class="text-caption text-grey">{{
                                            formatDate(currentDeparture.arrival_date)
                                        }}
                                    </div>
                                </div>
                            </div>

                            <v-sheet color="grey-lighten-4" rounded="lg" class="pa-3 mt-4">
                                <div class="d-flex align-center text-body-2 mb-1">
                                    <v-icon size="small" class="mr-2">mdi-bag-personal</v-icon>
                                    Багаж: <strong>до 20 кг</strong> <span class="text-grey ml-1">(в цене)</span>
                                </div>
                                <div class="d-flex align-center text-body-2">
                                    <v-icon size="small" class="mr-2">mdi-bag-carry-on</v-icon>
                                    Ручная кладь: <strong>до 5 кг</strong> <span class="text-grey ml-1">(в цене)</span>
                                </div>
                            </v-sheet>
                        </div>

                        <div class="flight-section">
                            <h4 class="text-uppercase text-grey-darken-1 mb-4">Возвращение</h4>

                            <div class="flight-row d-flex">
                                <div class="time-col font-weight-bold text-h6">
                                    {{ formatTime(currentDeparture.return_time) }}
                                </div>
                                <div class="path-col mx-4">
                                    <v-icon size="small" class="plane-icon">mdi-airplane</v-icon>
                                    <div class="dot"></div>
                                    <div class="line"></div>
                                </div>
                                <div class="info-col">
                                    <div class="font-weight-bold">{{ currentDeparture.return_city_name }},
                                        {{ currentDeparture.return_airport.airport_name }}
                                    </div>
                                    <div class="text-caption text-grey">{{
                                            formatDate(currentDeparture.return_date)
                                        }}
                                    </div>
                                    <div class="text-caption text-grey-lighten-1 mt-1">Enter Air,
                                        {{ currentDeparture.return_airport.id }}
                                    </div>
                                </div>
                            </div>

                            <div class="flight-row d-flex mt-n1">
                                <div class="time-col font-weight-bold text-h6">{{
                                        formatTime(currentDeparture.return_arrival_time)
                                    }}
                                </div>
                                <div class="path-col mx-4">
                                    <v-icon size="small" class="plane-icon">mdi-airplane</v-icon>
                                    <div class="dot"></div>
                                </div>
                                <div class="info-col">
                                    <div class="font-weight-bold">
                                        {{
                                            currentDeparture.airport.city.name
                                        }},{{ currentDeparture.airport.airport_name }}
                                    </div>
                                    <div class="text-caption text-grey">
                                        {{ formatDate(currentDeparture.return_arrival_date) }}
                                    </div>
                                </div>
                            </div>

                            <v-sheet color="grey-lighten-4" rounded="lg" class="pa-3 mt-4">
                                <div class="d-flex align-center text-body-2 mb-1">
                                    <v-icon size="small" class="mr-2">mdi-bag-personal</v-icon>
                                    Багаж: <strong>до 20 кг</strong> <span class="text-grey ml-1">(в цене)</span>
                                </div>
                                <div class="d-flex align-center text-body-2">
                                    <v-icon size="small" class="mr-2">mdi-bag-carry-on</v-icon>
                                    Ручная кладь: <strong>до 5 кг</strong> <span class="text-grey ml-1">(в цене)</span>
                                </div>
                            </v-sheet>
                        </div>
                    </v-sheet>
                </v-expand-x-transition>

                <v-sheet width="352" height="627" elevation="15" rounded="xl" class="info_card">
                    <div class="ml-4 mt-1 mb-5">
                        <h3 class="pb-1">{{ items.name }}</h3>
                        <div class="flex d-flex text-right">
                            <div class="text-h6 font-weight-bold mb-1">{{ items.base_price }} $</div>
                            <div class="text-caption text-grey pt-2 pl-1">/ за 1 человека</div>
                        </div>
                    </div>

                    <div class="item items font-weight-medium" @click="toggleMenu('date')">
                        <span> {{ formatDateRange(formattedSelectedDates) }}</span>
                        <v-icon class="chevron-icon" :class="{rotated : activeMenu === 'date'}"> mdi-chevron-down
                        </v-icon>
                    </div>
                    <v-expand-transition v-if="activeMenu === 'date'">
                        <div class="calendar-box">
                            <div class="calendar-top justify-space-between">
                                <v-icon class="cal-nav" @click="toPrevMonth"> mdi-chevron-left</v-icon>
                                <v-icon class="cal-nav" @click="toNextMonth"> mdi-chevron-right</v-icon>
                            </div>
                            <div class="d-flex">
                                <div class="calendr-month">
                                    <div class="calendar-title">{{ formatMonth(currentMonth) }}</div>
                                    <v-date-picker-month
                                        v-model="dates"
                                        :allowed-dates="allowed"
                                        :month="currentMonthParts.month"
                                        :year="currentMonthParts.year"
                                        #day="{props, item}"
                                    >
                                        <div class="dep-day" style="">
                                            <v-btn
                                                v-bind="props" dep-day
                                                :variant="item.isSelected ? 'outlined' : 'text'"
                                                :color="item.isSelected ? 'primary' : undefined"
                                                class="day-btn"
                                                style="flex-direction: column;"

                                            >
                                                <div>
                                                    <div>{{ item.localized }}</div>
                                                    <div
                                                        v-if="!item.isDisabled"
                                                        class="dep-price">
                                                        {{ depPriceDate(item.isoDate) }}{{ currency }}
                                                    </div>
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
                                        :allowed-dates="allowed"
                                        v-model="dates"
                                        :month="nextMonthParts.month"
                                        :year="nextMonthParts.year"
                                        #day="{item,props}"
                                    >
                                        <div class="dep-day">
                                            <v-btn
                                                v-bind="props" dep-day
                                                :variant="item.isSelected ? 'outlined' : 'text'"
                                                :color="item.isSelected ? 'primary' : undefined"
                                                class="day-btn"
                                                style="flex-direction: column;"
                                            >
                                                <div>
                                                    <div>{{ item.localized }}</div>
                                                    <div v-if="!item.isDisabled"
                                                         class="dep-price">{{ depPriceDate(item.isoDate) }}
                                                        {{ currency }}
                                                    </div>
                                                    <div></div>
                                                </div>
                                            </v-btn>
                                        </div>
                                    </v-date-picker-month>
                                </div>
                            </div>
                            <div class="calendar-offers" style="height: 74px; background-color: #f8f8f8">
                                <div class="offer-chip" style="height: 36px;" v-for="offer in calendarOffers"
                                     :key="offer.nights">
                                    <strong>{{ offer.nights }} дней</strong>
                                    <span>{{ offer.price }} {{ currency }} / за 1</span>
                                </div>
                            </div>
                            <div class="calendar-footer">
                                <div class="d-flex justify-center">
                                    <strong class="text-uppercase text-black"
                                            style="font-size: 23px; font-weight: 600;"> {{ finalPrice }}
                                        {{ currency }} </strong>
                                    <span
                                        style="font-weight: 300; font-size: 14px; padding-top: 7px; padding-left: 5px;">/ за {{
                                            totalTourists
                                        }} человека</span>
                                </div>
                                <v-btn @click="selectDate()" class="apply-btn">выбрать
                                    <v-icon> mdi-arrow-bottom-right</v-icon>
                                </v-btn>
                            </div>
                        </div>
                    </v-expand-transition>


                    <div class="item items" @click="toggleMenu('tr')">
                        <span>Туристы: <strong>{{ totalTourists }}</strong></span>
                        <v-icon class="chevron-icon" :class="{ 'rotated': activeMenu === 'tr'}">mdi-chevron-down
                        </v-icon>
                    </div>
                    <v-expand-transition>
                        <div v-if="activeMenu === 'tr'" class="tourists itemBox ">
                            <div class="row">
                                <div>Взрослые</div>
                                <div class="controls">
                                    <button @click="decrementAdults" :disabled="adults <= 1">−</button>
                                    <span>{{ adults }}</span>
                                    <button @click="incrementAdults">+</button>
                                </div>
                            </div>

                            <div class="row">
                                <div>Дети (0–17 лет)</div>
                                <div class="controls">
                                    <button @click="decrementChildren" :disabled="children <= 0">−</button>
                                    <span>{{ children }}</span>
                                    <button @click="incrementChildren">+</button>
                                </div>
                            </div>
                            <v-divider></v-divider>
                            <button class="select-btn" @click="selectTourists()">ВЫБРАТЬ ↓</button>
                        </div>
                    </v-expand-transition>


                    <div class="item items" @click="toggleMenu('rooms')">
                        <span> Номер: <strong>{{
                                selectedRoom?.room_type ?? items?.hotel?.roomTypes.find(t => t.is_base)?.room_type
                            }}</strong></span>
                        <v-icon class="chevron-icon" :class="{ 'rotated': activeMenu === 'rooms'}">mdi-chevron-down
                        </v-icon>
                    </div>
                    <v-expand-transition>
                        <div v-if="activeMenu === 'rooms'" class="itemBox options-box">
                            <div class="option-row">
                                <input type="radio"
                                       class="radio"
                                       :checked="!selectedRoom">
                                <div class="flex mr-14 ">
                                    <label class="radio-label flex-column flex align-lg-start mr-16 "
                                           @click="selectedRoom = null">
                                        <span class="ml-2"><strong>{{
                                                items?.hotel?.roomTypes.find(t => t.is_base)?.room_type
                                            }}</strong></span>
                                    </label>
                                </div>
                                <span class="price-mode text-caption text-black pb-3"> в цене</span>
                            </div>
                            <div
                                class="option-row"
                                v-for="room in items.hotel?.roomTypes"
                                :key="room.id"
                                @click="selectedRoom = room">

                                <label class="radio-label">
                                    <input type="radio" class="radio" name="{{room.id}}"
                                           :checked="selectedRoom?.id === room.id"/>
                                    <span class="ml-2">{{ room.room_type }}</span>
                                </label>
                                <span class="price-mod text-black text-caption">
                                    {{
                                        '+' + room.price_per_person + '$' + '/за номер'
                                    }}
                                </span>
                            </div>
                            <v-divider></v-divider>
                            <button class="apply-btn" @click="selectRoom(selectedRoom)">ВЫБРАТЬ ↓</button>
                        </div>
                    </v-expand-transition>

                    <div class="item items" @click="toggleMenu('nut')">
                        <span> Питание: <strong>{{
                                selectedNutrition?.name ?? items?.hotel?.nutrition.find(n => n.is_base)?.name
                            }} </strong></span>
                        <v-icon class="chevron-icon" :class="{'rotated' : activeMenu === 'nut'}">
                            mdi-chevron-down
                        </v-icon>
                    </div>
                    <v-expand-transition>
                        <div v-if="activeMenu === 'nut'" class="itemBox options-box">
                            <div class="option-row">
                                <input type="radio"
                                       class="radio mt-1"
                                       :checked="!selectedNutrition">
                                <div class="flex">
                                    <label class="radio-label flex-column flex align-lg-start mr-16 "
                                           @click="selectedNutrition = null">
                                        <span class="pr-16"><strong>{{
                                                items?.hotel?.nutrition.find(n => n.is_base)?.name
                                            }}</strong></span>
                                    </label>
                                </div>
                                <span
                                    class="price-mode text-caption text-black pb-3">{{ items?.hotel?.nutrition.price }} в цене</span>
                            </div>
                            <div
                                class="option-row"
                                v-for="nut in items.hotel?.nutrition"
                                :key="nut.id"
                                @click="selectedNutrition = nut"
                            >
                                <label class="radio-label">
                                    <input type="radio" class="radio mt-2" name="{{nut.id}}"
                                           :checked="selectedNutrition?.id === nut.id">
                                    <span class="ml-2 mt-1">{{ nut.name }}</span>
                                </label>
                                <label class="price-mod text-black text-caption mt-2">+ {{ nut.price }}$</label>
                            </div>
                            <v-divider></v-divider>
                            <v-btn class="apply-btn" @click="selectNutrition(selectedNutrition)"> Выбрать
                                <v-icon> mdi-arrow-down</v-icon>
                            </v-btn>
                        </div>
                    </v-expand-transition>

                    <div class="item items" @click="toggleMenu('dep')">
                        <span>
                            Вылет: <strong>{{
                                selectedDeparture?.airport.airport_name || items.tour_departures[0].airport.airport_name
                            }}</strong>
                        </span>
                        <v-icon class="chevron-icon" :class="{ 'rotated': activeMenu === 'dep' }">mdi-chevron-down
                        </v-icon>
                    </div>

                    <v-expand-transition>
                        <div v-if="activeMenu === 'dep'" class="itemBox options-box pt-3">
                            <div class="option-row option-row--multi">
                                <label class="radio-label" @click="selectedDeparture = null">
                                    <input type="radio" class="radio" :checked="!selectedDeparture">
                                    <span class="option-text">
                                        <strong>{{ items.tour_departures?.[0]?.city_name }}, {{
                                                items.tour_departures?.[0]?.airport.airport_name
                                            }}</strong>
                                        <span class="option-sub text-caption">({{
                                                formatTime(items.tour_departures?.[0]?.departure_time)
                                            }})</span>
                                    </span>
                                </label>
                                <span class="price-mode text-caption text-black">в цене</span>
                            </div>
                            <span v-if="items.tour_departures?.length" class="text-uppercase pl-2">
                                 Другие доступные даты и места отправления:
                                </span>
                            <div
                                v-for="dep in items.tour_departures"
                                :key="dep.id"
                                class="option-row"
                                @click="selectedDeparture = dep"
                            >
                                <label class="radio-label">
                                    <input
                                        type="radio"
                                        class="radio"
                                        :checked="selectedDeparture?.id === dep.id"
                                    >
                                    <span class="option-text">
                                        <strong>{{ dep.city_name }}, {{ dep.airport.airport_name }}</strong>
                                        <span
                                            class="option-sub text-caption">({{
                                                formatTime(dep.departure_time)
                                            }})</span>
                                    </span>
                                </label>
                                <span class="price-mod text-black text-caption mt-2 ">+{{ dep.price }}</span>
                            </div>

                            <v-divider></v-divider>
                            <button class="apply-btn" @click="selectDeparture(selectedDeparture)">
                                ВЫБРАТЬ
                                <v-icon>mdi-arrow-down</v-icon>
                            </button>
                        </div>
                    </v-expand-transition>

                    <div class="">
                        <div class="item items mr-2 pr-15 d-flex justify-center" style="width: 330px;"
                             @click="toggleMenu('sched')">
                            <v-icon style="height: 24px; width: 24px;" class="pt-2 pr-2"> mdi-airplane-clock</v-icon>
                            <p style="cursor:pointer; border-bottom: black 1px solid; height: 19px;">
                                Расписание перелёта
                            </p>
                        </div>
                        <div class="d-flex justify-center mt-9">
                            <h2 class="text-uppercase text-black "> итог: {{ finalPrice }} $</h2>
                        </div>
                        <v-btn @click="submitBooking()" :loading="submitting" class="ml-11 text-uppercase"
                               baseColor="red"
                               style="width: 217px; height: 40px; border-radius: 99px; ">оставить заявку
                            <v-icon>mdi-arrow-down</v-icon>
                        </v-btn>
                    </div>

                </v-sheet>
            </div>
            <success-modal v-if="success" @close="success = false"/>
        </v-container>
    </section>
</template>

<style scoped>
.schedule {
    height: 676px;
    width: 345px;
    position: absolute;
    right: 368px;
    z-index: 10;
    border-radius: 15px;
}


.apply-btn {
    margin-left: 70px;
    width: 144px;
    border-radius: 100px;
    background-color: black;
    color: white;
    height: 40px;
    border-top: black;
}

.itemBox {
    position: absolute;
    transform: translateX(-30px);
    background: #fff;
    height: auto;
    border-radius: 15px;
    padding: 20px;
    z-index: 20;
}

.calendar-title {
    text-align: center;
    font-weight: 600;
    text-transform: capitalize;
}

.dep-price {
    font-size: 10px;
    line-height: 1;
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
    width: 740px;
    transform: translateX(-390px);
}

.calendar-top {
    display: flex;
    align-items: flex-start;
    gap: 12px;
}


.cal-nav {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 1px solid #dedede;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    margin-top: 8px;
}

.calendar-offers {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    width: auto;
    gap: 12px;
    margin-top: 20px;
    margin-right: -20px;
    margin-left: -20px;
    padding-right: 20px;
    padding-left: 20px;
}

.offer-chip {
    border: 1px solid #e2e2e2;
    border-radius: 10px;
    padding: 8px 12px;
    background: #fff;
    font-size: 12px;
    display: flex;
    gap: 6px;
    align-items: baseline;
}

.calendar-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 22px;
}

.options-box {
    min-height: auto;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.option-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    width: 316px;
    min-height: 40px;
    cursor: pointer;
    border-radius: 8px;
    transition: background 0.2s;
}

.option-row:hover {
    background: #f5f5f5;
}

.radio-label {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    cursor: pointer;
}

.radio {
    height: 20px;
    width: 20px;
    accent-color: purple;
}

.option-text {
    display: flex;
    flex-direction: column;
    gap: 2px;
    line-height: 1.2;
    white-space: normal;
}

.option-sub {
    color: #666;
}

.items {
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
}

.chevron-icon {
    transition: transform 0.3s ease;
}

.chevron-icon.rotated {
    transform: rotate(180deg);
}

.tourists .row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 0;
}


.tourists .controls {
    display: flex;
    align-items: center;
    gap: 16px;
}

.tourists .controls button {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: 1px solid #ddd;
    background: #fff;
    font-size: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    color: #333;
}

.tourists .controls button:hover:not(:disabled) {
    border-color: #333;
    background: #f5f5f5;
}

.tourists .controls button:disabled {
    opacity: 0.3;
    cursor: not-allowed;
}

.tourists .controls span {
    font-size: 18px;
    font-weight: 600;
    min-width: 20px;
    text-align: center;
}

.tourists .select-btn {
    width: 100%;
    padding: 14px;
    background: #000;
    color: #fff;
    border: none;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 0.5px;
    cursor: pointer;
    margin-top: 20px;
    transition: background 0.2s ease;
}

.tourists .select-btn:hover {
    background: #333;
}

.item {
    border-top: #D4D4D4 1px solid;
    padding: 16px;
}

.top-block {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-top: 20px;
    position: relative;
}

.left-column {
    display: flex;
    flex-direction: column;
}

.main_image {
    border-radius: 30px;
    width: 736px;
    height: 480px;
    object-fit: cover;
}

.sub_gallery {
    display: flex;
    gap: 12px;
    margin-top: 12px;
}

.sub_image {
    border-radius: 20px;
    max-width: 175px;
    max-height: 112px;
    object-fit: cover;
}

.info_card {
    padding: 20px;
}

.breadcrumbs {
    font-size: 0.9rem;
    color: #555;
    margin: 16px 0;
}

.crumb {
    cursor: pointer;
    color: gray;
}

.crumb.active {
    color: #333;
    cursor: default;
}
</style>
