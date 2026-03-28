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


const items = ref([
    {
        title: 'Home',
        disabled: false,
        href: '/',
    },
    {
        title: 'Hotels',
        disabled: true,
        href: '/hotels'
    }
])


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


onBeforeUnmount(() => stopScroll());
</script>


<template>
    <section class="hot-hotels">
        <v-container>
            <div>
                <v-breadcrumbs class="breadcrumbs" :items="items">
                </v-breadcrumbs>
            </div>
            <div>
                <div>
                    <v-card-title class="text-h6 text-md-h5 text-lg-h4">
                        <strong>РЕКОМЕНДАЦИИ</strong>
                    </v-card-title>
                </div>

            </div>
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
                        class="hotel-scroll ga-8"
                    >
                        <v-sheet
                            v-for="h in hotels"
                            :key="h.id"
                            rounded="xl"
                            class="hotel d-flex align-center justify-space-between"
                            height="280px"
                            width="800px"
                        >
                            <v-img
                                :src="h.front_images[0]"
                                height="100%"
                                width="384"
                                class="image"
                                cover
                            />
                            <div class="pa-4" style="width: 100%; height: 100%;">
                                <div class="d-flex align-flex text-caption text-grey-darken-1">{{ h.country }},
                                    {{ h?.city }}
                                </div>
                                <div class="mb-2 d-flex align-center ">
                                    <h3 class="text-h5 font-weight-bold w75">{{ h.name }}</h3>
                                </div>
                                <div class="d-flex align-center mb-5">
                                    <v-rating
                                        :model-value="parseFloat(h?.rating) || 0"
                                        color="red"
                                        active-color="red"
                                        density="compact"
                                        size="small"
                                        readonly
                                        half-increments
                                    ></v-rating>
                                </div>
                                <div class=" d-flex align-center mb-3">
                                    <v-chip color="purple" variant="flat" size="small">{{ h.rating }}</v-chip>
                                </div>
                                <div class="align-center">
                                    <div
                                        v-for="f in h.features.slice(0,4)"
                                        :key="f.id"
                                        class="d-flex align-center"
                                    >
                                        <v-icon size="small" color="purple" class="mr-2">mdi-check-bold</v-icon>

                                        <span>
                                            {{ f.name }} {{ f.value }}
                                            </span>
                                    </div>
                                </div>
                            </div>
                        </v-sheet>


                        <v-btn
                            class="arrows right-arrow mdi mdi-chevron-right"
                            :class="{ 'show-arrow': isHovering }"
                            @mousedown="startScrollRight"
                            @mouseup="stopScroll"
                            @mouseleave="stopScroll"
                        />
                    </div>
                            <div class="scrollbar">
                                <div
                                    class="thumb"
                                    :style="{ left: thumbLeft + 'px', width: thumbWidth + 'px' }"
                                ></div>
                            </div>
                </div>
            </v-hover>
        </v-container>
    </section>
</template>


<style scoped>

.breadcrumbs :deep(.v-breadcrumbs-item--disabled) {
    color: #ec1c24;
    opacity: 1;
}

.breadcrumbs {
    font-size: 0.9rem;
    color: #555;
    margin: 16px 0;
}


.scroll-wrapper {
    position: relative;
}

.hot-hotels {
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
    border-radius: 24px 24px 0 0;
    overflow: hidden;
}

.hotel {
    border: gray solid 1px;
    min-height: 280px;
    min-width: 800px;
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
