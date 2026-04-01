<script setup>
import {ref, onMounted} from "vue";
import { useI18n } from "vue-i18n";
import NewsService from "../../services/NewsService.js";

const news = ref([])
const { t } = useI18n({ useScope: 'global' })

onMounted(async () => {
    news.value = await NewsService.getNews();
})
</script>

<template>
    <v-container fluid class="py-16 px-6 " style="background-color: #F8F8F8;">
        <div class="text-center mb-12 position-relative">
            <div class="decorative-text">News</div>
            <h2 class="text-h3 font-weight-bold mb-2">{{ t('home.newsTitle') }}</h2>
            <p class="text-subtitle-1 text-grey-darken-1">{{ t('home.newsSubtitle') }}</p>
        </div>

        <v-row dense class="news-grid">
            <v-col
                v-for="n in news"
                :key="n.id"
                :cols="12"
                :md="n.cols"
            >
                <v-card
                    class="news-card rounded-xl"
                    :height="n.rows === 2 ? 515 : 250"
                    hover
                >
                    <v-img
                        :src="`/storage/${n.image}`"

                        cover
                        height="100%"
                        class="rounded-xl"
                    >
                        <div class="news-overlay d-flex flex-column justify-end h-100 pa-6">
                            <div class="text-white text-h6 font-weight-bold mb-2">
                                {{ n.title }}
                            </div>
                            <div class="read-more text-white">
                                {{ t('home.readArrow') }}
                            </div>
                        </div>
                    </v-img>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<style scoped>
.decorative-text {
    position: absolute;
    left: 10%;
    top: 50%;
    transform: translateY(-50%);
    font-size: 120px;
    font-weight: 300;
    color: rgba(0, 0, 0, 0.03);
}

.news-grid {
    max-width: 1400px;
    margin: 0 auto;
}

.news-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
}

.news-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15) !important;
}

.news-overlay {
    background: linear-gradient(
        to top,
        rgba(0, 0, 0, 0.75) 0%,
        rgba(0, 0, 0, 0.4) 50%,
        transparent 100%
    );
}

.read-more {
    font-size: 14px;
    opacity: 0.9;
    transition: opacity 0.3s ease;
}

.news-card:hover .read-more {
    opacity: 1;
}


</style>
