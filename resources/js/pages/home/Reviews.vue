<script setup>
import { ref, onMounted } from "vue";
import ReviewsService from "../../services/ReviewsService.js";


const scrollEl = ref(null);
const thumbLeft = ref(0);
const thumbWidth = ref(60);
const reviews = ref([]);
const page = ref(1);
const lastPage = ref(null);
const loading = ref(false);

async function loadReviews() {
    if (loading.value) return;
    if (lastPage.value && page.value > lastPage.value) return;

    loading.value = true;

    const res = await ReviewsService.getReviews(page.value);

    reviews.value.push(...res.data);
    lastPage.value = res.meta.last_page;
    page.value++;

    loading.value = false;
}


onMounted(async () => {
    await loadReviews();

    requestAnimationFrame(() => {
        const el = scrollEl.value;
        if (!el) return;

        const update = () => {
            const maxScroll = el.scrollWidth - el.clientWidth;
            const ratio = el.scrollLeft / maxScroll;

            if (maxScroll > 0) {
                thumbLeft.value = ratio * (el.clientWidth - thumbWidth.value);
            }

            if (ratio > 0.9) {
                loadReviews();
            }

        };
        update();
        el.addEventListener("scroll", update);
    });
});
</script>




<template>
    <section class="reviews">
        <v-container style="height: 940px">
            <div class="mt-16" align="center">
                <div class="decorative-text">Reviews</div>
                <v-card-title class="text-h6 text-md-h5 text-lg-h4">
                    <strong>ОТЗЫВЫ</strong>
                </v-card-title>

                <v-card-text>ВПЕЧАТЛЕНИЯ НАШИХ ПУТЕШЕСТВЕННИКОВ</v-card-text>
                <v-hover v-slot="{isHovering, props}">
                    <div class="scroll-wrapper" v-bind="props">
                        <v-btn class="arrows left-arrow mdi mdi-chevron-left" :class="{'show-arrow' : isHovering}"
                               @mousedown="scrollLeft"
                               @mouseup="stopScroll"
                               @mouseleave="stopScroll"
                        />
                        <div class="scroll-wrapper">
                            <div class="scroll" ref="scrollEl">
                                <div class="reviews-row">
                                    <v-sheet
                                        v-for="r in reviews"
                                        :key="r.id"
                                        class="review-card"
                                        width="352"
                                        color="#F8F8F8"
                                    >
                                        <v-img
                                            class="avatar"
                                            :src="`/storage/${r.avatar}`"
                                            height="64"
                                            width="64"
                                            cover
                                        />

                                        <v-rating
                                            :model-value="parseFloat(r.rating) || 0"
                                            color="red"
                                            active-color="red"
                                            density="compact"
                                            size="small"
                                            readonly
                                            half-increments
                                        />

                                        <v-card-subtitle class="name">
                                            {{ r.name }} из {{ r.person_from }}
                                        </v-card-subtitle>

                                        <v-card-subtitle class="trip">
                                            Летал в {{ r.flight_to }} {{ r.flight_date }} в отель {{ r.was_in_hotel}}
                                        </v-card-subtitle>

                                        <v-card-text class="text">
                                            {{ r.main_text }}
                                        </v-card-text>
                                    </v-sheet>
                                </div>
                            </div>
                        </div>
                    <v-btn class="arrows right-arrow mdi mdi-chevron-right" :class="{'show-arrow' : isHovering}"
                           @mousedown="scrollRight"
                           @mouseup="stopScroll"
                           @mouseleave="stopScroll"
                    />
                    </div>

                </v-hover>
                <div class="scrollbar">
                    <div
                        class="thumb"
                        :style="{ left: thumbLeft + 'px', width: thumbWidth + 'px' }"
                    ></div>
                </div>
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

.reviews {
    border-radius: 16px;
    padding: 1rem;
    position: relative;
}

.scroll-wrapper {
    position: relative;
    margin-top: 40px;
}

.scroll {
    overflow-x: auto;
    overflow-y: hidden;
    white-space: nowrap;
}

.reviews-row {
    display: flex;
    gap: 32px;
    flex-wrap: nowrap;
}

.review-card {
    border-radius: 16px;
    height: auto;
    padding: 1rem;
    display: inline-flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    width: 352px;
}

.avatar {
    border-radius: 50%;
    margin-top: 10px;
}


.trip {
    opacity: 0.7;
    font-size: 14px;
    white-space: normal;
}

.text {
    white-space: normal;
}
.scroll {
    display: flex;
    gap: 1rem;
    overflow-x: auto;
    padding-bottom: 0.5rem;
    scrollbar-width: none;
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
    z-index: 10;
}

.left-arrow {
    left: -20px;
}

.right-arrow {
    right: -20px;
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
