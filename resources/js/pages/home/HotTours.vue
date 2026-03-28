<script setup>
import {ref, onMounted} from 'vue';
import TourService from '../../services/TourService.js';
import ReviewsService from "../../services/ReviewsService.js";

const tours = ref([]);
const scrollEl = ref(null);
const thumbLeft = ref(0);
const thumbWidth = ref(60);
const scrollInterval = ref(60);
const loading = ref(false);
const lastPage = ref(null);
const page = ref(1)

async function loadTours() {
    if (loading.value) return;
    if (lastPage.value && page.value > lastPage.value) return;

    loading.value = true;

    try {
        const res = await TourService.getToursPage(page.value);
        tours.value.push(...res.data);
        lastPage.value = res.meta.last_page;
        page.value++;

    } finally {
        loading.value = false;
    }
}

const scrollLeft = () => {
    const el = scrollEl.value;
    if (!el) return;

    stopScroll();

    scrollInterval.value = setInterval(() => {
        el.scrollBy({left: -20, behavior: 'auto'});
    }, 16)
};

const scrollRight = () => {
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
}

onMounted(async () => {
    await loadTours();

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
            if(ratio < 0.9){
                loadTours()
            }
            thumbLeft.value = ratio * (el.clientWidth - thumbWidth.value);
        };

        update();
        el.addEventListener('scroll', update);
    });
});
</script>

<template>
    <section class="hot-tours">
        <v-container>
            <v-card-title class="text-h6 text-md-h5 text-lg-h4">
                <strong>ГОРЯЩИЕ ТУРЫ</strong>
            </v-card-title>
            <v-card-text>ПОЙМАЙТЕ МОМЕНТ</v-card-text>
                <div class="decorative-text">Tours</div>
            <v-hover v-slot="{ isHovering, props }">
                <div class="scroll-wrapper" v-bind="props">
                    <v-btn class="arrows left-arrow mdi mdi-chevron-left" :class="{'show-arrow' : isHovering}"
                           @mousedown="scrollLeft"
                           @mouseup="stopScroll"
                           @mouseleave="stopScroll"
                    />
                    <div class="scroll mt-16" ref="scrollEl">

                        <v-sheet
                            v-for="t in tours"
                            :key="t.id"
                            class="tour"
                            height="340"
                        >
                            <v-img
                                :src="t.image"
                                cover
                                class="tour-bg"
                            />

                            <div class="tour-content">
                                <div class="d-flex">
                                    <v-chip outlined color="white">
                                        {{ t.days }} {{ [1, 2, 3, 4].includes(t.days) ? 'дня' : 'дней' }}
                                    </v-chip>
                                    <v-chip outlined color="white">
                                        ОТ {{ t.base_price }}₽
                                    </v-chip>
                                </div>

                                <div class="text-white mt-auto">
                                    <div class="text-h6 font-weight-bold">
                                        {{ t.country }} • {{ t.city }}
                                    </div>
                                    <div class="text-subtitle-2 font-weight-medium">
                                        {{ t.date }}
                                    </div>

                                    <div class="d-flex align-center mt-2">
                                        <router-link :to="`/tour/${t.id}`" class="nav-link">
                                            Узнать подробнее
                                        </router-link>
                                        <v-icon size="20">mdi-arrow-right-circle-outline</v-icon>
                                    </div>
                                </div>
                            </div>
                        </v-sheet>
                    </div>
                    <div class="flex d-flex justify-end" v-if="isHovering">
                        <v-btn class="arrows right-arrow mdi mdi-chevron-right"
                               :class="{'show-arrow' : isHovering}"
                               @mousedown="scrollRight"
                               @mouseup="stopScroll"
                               @mouseout="stopScroll"
                        />
                    </div>
                </div>
            </v-hover>
            <div class="scrollbar">
                <div
                    class="thumb"
                    :style="{ left: thumbLeft + 'px', width: thumbWidth + 'px' }"
                ></div>
            </div>
        </v-container>
    </section>
</template>

<style scoped>

.decorative-text {
    position: absolute;
    right: 60%;
    transform: translateY(-50%);
    font-size: 120px;
    font-weight: 300;
    font-family: "Milanova", normal;
    color: rgba(0, 0, 0, 0.03);
}



.tour-bg {
    position: absolute;
    inset: 0;
    z-index: 1;
}

.tour-content {
    position: relative;
    z-index: 2;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.tour {
    min-width: 260px;
    min-height: 340px;
    background-position: center;
    background-size: cover;
    border-radius: 16px;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
}

.hot-tours {
    height: 814px;
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

.scroll {
    display: flex;
    gap: 1rem;
    overflow-x: auto;
    padding-bottom: 0.5rem;
    scrollbar-width: none;
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

.scroll-wrapper {
    position: relative;
}


.nav-link {
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
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
