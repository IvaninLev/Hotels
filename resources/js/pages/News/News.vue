<script setup>

import {onMounted, ref} from "vue";
import NewsService from "../../services/NewsService.js";

const news = ref([])

const items = ref([
    {
        title: 'Home',
        disabled: false,
        href: '/',
    },
    {
        title: 'News',
        disabled: true,
        href: '/news'
    }
])


onMounted(async () => {
    news.value = await NewsService.getNews();
})
</script>

<template>
    <section class="news">
        <v-container>
            <div>
                <v-breadcrumbs class="breadcrumbs" :items="items">
                </v-breadcrumbs>
            </div>
            <div>
                <div>
                    <v-card-title class="text-h6 text-md-h5 text-lg-h4">
                        <strong>НОВОСТИ</strong>
                    </v-card-title>
                    <v-card-text class="text-uppercase text-h6">события в мире туризма</v-card-text>
                </div>

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
                                    читать →
                                </div>
                            </div>
                        </v-img>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </section>
</template>

<style scoped>

.news {
    height: auto;
}

.breadcrumbs :deep(.v-breadcrumbs-item--disabled) {
    color: #ec1c24;
    opacity: 1;
}

.breadcrumbs {
    font-size: 0.9rem;
    color: #555;
    margin: 16px 0;
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
