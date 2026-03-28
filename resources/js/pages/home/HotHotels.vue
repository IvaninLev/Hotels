<script setup>
import {ref, onMounted, onBeforeUnmount} from "vue";
import HotelService from "../../services/HotelService.js";
import TourService from "../../services/TourService.js";

const hotels = ref([]);
const scrollEl = ref(null);
const thumbLeft = ref(0);
const thumbWidth = ref(60);
const toursByHotel = ref({});
const page = ref(1);
const lastPage = ref(null);
const loading = ref(false);


const scrollInterval = ref(null);

async function loadHotels() {
    if (loading.value) return;
    if (lastPage.value && page.value > lastPage.value) return;

    loading.value = true;

    try {
        const res = await HotelService.getHotelsPage(page.value);
        hotels.value.push(...res.data);
        lastPage.value = res.meta.last_page;
        page.value++;
    } finally {
        loading.value = false;
    }
}


const startScrollLeft = () => {
    const el = scrollEl.value;
    if (!el) return;
    stopScroll();
    scrollInterval.value = setInterval(() => {
        el.scrollBy({left: -10, behavior: "auto"});
    }, 16);
};

const startScrollRight = () => {
    const el = scrollEl.value;
    if (!el) return;
    stopScroll();
    scrollInterval.value = setInterval(() => {
        el.scrollBy({left: 10, behavior: "auto"});
    }, 16);
};

const stopScroll = () => {
    if (scrollInterval.value) {
        clearInterval(scrollInterval.value);
        scrollInterval.value = null;
    }
};

onMounted(async () => {
    const [hotelsData, toursData] = await Promise.all([
        HotelService.getHotelsPage(page.value),
        TourService.getTours()
    ]);

    hotels.value = hotelsData.data ?? hotelsData;
    lastPage.value = hotelsData.meta?.last_page ?? null;
    page.value = (hotelsData.meta?.current_page ?? 1) + 1;

    const map = {};
    for (const t of toursData) {
        const hotelId = t.hotel_id ?? t.hotel?.id;
        if (!hotelId || map[hotelId]) continue;
        map[hotelId] = t.id;
    }
    toursByHotel.value = map;

    requestAnimationFrame(() => {
        const el = scrollEl.value;
        if (!el) return;

        const update = () => {
            const maxScroll = el.scrollWidth - el.clientWidth;
            if (maxScroll <= 0) {
                thumbLeft.value = 0;
                return;
            }
            const ratio = el.scrollLeft / maxScroll;
            if (ratio < 0.9) {
                loadHotels();
            }
            thumbLeft.value = ratio * (el.clientWidth - thumbWidth.value);
        };

        update();
        el.addEventListener("scroll", update);
    });
});

const tourLink = (hotel) => {
    const tourId = toursByHotel.value[hotel.id];
    return tourId ? `/tour/${tourId}` : `/hotel/${hotel.id}`;
};

const hasTour = (hotel) => Boolean(toursByHotel.value[hotel.id]);

onBeforeUnmount(() => stopScroll());
</script>


<template>
    <section class="hot-hotels">
        <v-container>
            <div class="mt-16" align="center">
                <div class="decorative-text">Hotels</div>
                <v-card-title class="custom-title pt-16 text-md-h5 text-lg-h4">
                    <strong class="">ПОПУЛЯРНЫЕ ОТЕЛИ</strong>
                </v-card-title>

                <v-card-text class="custom-subtext">
                    УЮТ И РОСКОШЬ В ЛУЧШИХ ОТЕЛЯХ МИРА
                </v-card-text>

                <v-hover v-slot="{ isHovering, props }">
                    <div class="scroll-wrapper hover-area" v-bind="props">

                        <v-btn
                            class="arrows left-arrow mdi mdi-chevron-left"
                            :class="{ 'show-arrow': isHovering }"
                            @mousedown="startScrollLeft"
                            @mouseup="stopScroll"
                            @mouseleave="stopScroll"
                        />

                        <div
                            ref="scrollEl"
                            class="hotel-scroll d-flex flex-row flex-nowrap overflow-x-auto ga-8"
                        >
                            <v-sheet
                                v-for="h in hotels"
                                :key="h.id"
                                class="hotel-card image rounded-xl d-flex flex-column justify-space-between pa-4"
                                elevation="3"
                                :style="{ backgroundImage: `url(${h.front_images[0] || ''})` }"
                            >
                                <div class="flex d-flex justify-end">
                                    <v-card-title class="text-h4 text-white rating">
                                        {{ parseFloat(h.rating) }}


                                    </v-card-title>
                                    <v-icon class="mdi mdi-star-outline text-white pr-5"></v-icon>
                                </div>

                                <div class="justify-start text-white">
                                    <v-card-title
                                        class="text-h5 mt-5 font-weight-bold text-star"
                                        style="text-align: start"
                                    >
                                        {{ h.name }}
                                    </v-card-title>

                                    <div class="d-flex align-center mt-2">
                                        <router-link :to="tourLink(h)" class="nav-link"
                                                     :class="{'disabled-link': !hasTour(h)}">
                                            Узнать подробнее
                                        </router-link>
                                        <v-icon size="20">mdi-arrow-right-circle-outline</v-icon>
                                    </div>
                                </div>
                            </v-sheet>
                        </div>

                        <div class="scrollbar">
                            <div
                                class="thumb"
                                :style="{ left: thumbLeft + 'px', width: thumbWidth + 'px' }"
                            ></div>
                        </div>

                        <v-btn
                            class="arrows right-arrow mdi mdi-chevron-right"
                            :class="{ 'show-arrow': isHovering }"
                            @mousedown="startScrollRight"
                            @mouseup="stopScroll"
                            @mouseleave="stopScroll"
                        />
                    </div>
                </v-hover>
            </div>
        </v-container>
    </section>
</template>


<style scoped>
.decorative-text {
    position: absolute;
    right: 40%;
    transform: translateY(-50%);
    font-size: 120px;
    font-weight: 300;
    font-family: "Milanova", normalf;
    color: rgba(0, 0, 0, 0.03);
}


.nav-link {
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
}

.disabled-link {
    opacity: 0.65;
    pointer-events: none;
}

.rating {
    font-weight: 400;
    font-style: normal;
    font-size: 65px;
    line-height: 100%;
    letter-spacing: 0%;
    text-align: right;
    text-transform: uppercase;

}

.scroll-wrapper {
    position: relative;
}

.hot-hotels {
    background-color: #F8F8F8;
    min-height: 898px;
    width: 100%;
}

.arrows {
    width: 32px;
    height: 32px;
    padding: 0;
    min-width: 0;
    border-radius: 50%;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.show-arrow {
    opacity: 1;
}


.left-arrow, .right-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10;
}

.left-arrow {
    left: -20px;
}

.right-arrow {
    right: -20px;
}

.image {
    background-position: center;
    background-size: cover;
}

.hotel-card {
    min-height: 400px;
    min-width: 544px;
}

.custom-title {
    font-size: 35px;

}

.custom-subtext {
    font-size: 25px;
}

.hotel-scroll {
    display: flex;
    gap: 1rem;
    overflow-x: auto;
    padding-bottom: 0.5rem;

    scrollbar-width: none;
    -ms-overflow-style: none;
}

.hotel-scroll::-webkit-scrollbar {
    display: none;
}

.scrollbar {
    position: relative;
    height: 2px;
    background: #0002;
    margin-top: 52px;
    color: #1C1C1C;
    border-radius: 2px;
    overflow: hidden;
}

.thumb {
    position: absolute;
    top: 0;
    height: 100%;
    background: #000;
    border-radius: 2px;
    transition: left 0.1s linear;
}
</style>
