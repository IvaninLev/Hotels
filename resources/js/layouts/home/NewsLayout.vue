<script setup>
const newsList = [
    {
        title: "",
        image: "",
        route: "",
        cols: 6,
    },

];
</script>
<template>
    <v-container fluid class="py-12">
        <!-- Заголовок -->
        <div class="text-center mb-12">
            <h2 class="text-h4 font-weight-bold">НОВОСТИ</h2>
            <p class="text-subtitle-1">СОБЫТИЯ В МИРЕ ТУРИЗМА</p>
        </div>

        <!-- Сетка -->
        <v-row dense>
            <v-col
                v-for="(news, i) in newsList"
                :key="i"
                :cols="news.cols"
                :md="news.cols"
            >
                <v-card
                    class="rounded-xl d-flex flex-column justify-end"
                    height="250"
                    :to="news.route"
                >
                    <v-img
                        :src="news.image"
                        cover
                        height="100%"
                        class="rounded-xl"
                    >
                        <div
                            class="d-flex flex-column justify-end h-100 pa-4"
                            style="background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);"
                        >
                            <div class="text-white text-subtitle-1 font-weight-bold">
                                {{ news.title }}
                            </div>
                            <div class="mt-2 text-caption text-white">читать →</div>
                        </div>
                    </v-img>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>


<style scoped>
h2 {
    letter-spacing: 2px;
}
</style>
