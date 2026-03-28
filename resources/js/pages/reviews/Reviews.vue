<script setup>
import ReviewModal from "../../components/modals/ReviewModal.vue";
import router from "../../router/index.js";
import {computed, onMounted, ref, watch} from "vue";
import reviewsService from "../../services/ReviewsService.js";
import ReviewsService from "../../services/ReviewsService.js";
import {useSearchStore} from "../../stores/useSearchStore.js";

const modal = ref(false)
const reviews = ref([])
const page = ref(1)
const searchStore = useSearchStore()
const goHome = () => {
    router.push("/");
};

const handleSubmit = (rev) => {
    modal.value = false
    reviews.value =[rev, ...reviews.value]
}

const totalPages = computed(() => {
    const lastPage = searchStore.reviewsMeta?.last_page;
    return Math.max(1, Number.isFinite(lastPage) ? lastPage : 1)

})
watch(totalPages, (next) => {
    if (page.value > next) {
        page.value = next
    }
})
const nextPage = () => {
    if (page.value < totalPages.value) page.value++;
}
const prevPage = () => {
    if (page.value > 1) page.value--;
}

const load = async () => {
    const res = await reviewsService.getReviews(page.value);
    reviews.value = res.data ?? res ?? [];
    searchStore.reviewsMeta = res.meta ?? [];
}
watch(page, () => load())
onMounted(() => load())
</script>

<template>
    <v-container>
        <div class="breadcrumbs">
            <span class="crumb" @click="goHome">главная</span>
            <span class="divider">/</span>
            <span class="crumb active">отзывы</span>
        </div>

        <div class="pt-10">
            <div class="flex d-flex justify-space-between">
                <h1>ОТЗЫВЫ</h1>
                <div class="pt-2">
                    <v-btn @click="modal = true" variant="outlined" class="button border-xs" rounded>
                        <span class="text-button font-weight-medium">оставить отзыв</span>
                    </v-btn>
                </div>
            </div>
        </div>
        <div>
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
                        Летал в {{ r.flight_to }} {{ r.flight_date }} в отель {{ r.was_in_hotel }}
                    </v-card-subtitle>

                    <v-card-text class="text">
                        {{ r.main_text }}
                    </v-card-text>
                </v-sheet>
            </div>
            <ReviewModal v-if="modal" @close="modal = false" @submit="handleSubmit"></ReviewModal>

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
</template>

<style scoped>
.reviews {
    border-radius: 16px;
    padding: 1rem;
    position: relative;
}


.reviews-row {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 38px;
}

.review-card {
    border-radius: 16px;
    height: auto;
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
.custom-pagination {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    margin-top: 30px;
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

.button {
    border-color: black;
    background-color: transparent;
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
