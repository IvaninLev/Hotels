<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import TourService from "../../services/TourService.js";

// const tours = ref([])
onMounted(async () => {
    try {
  await TourService.getTours()
      .then(response =>{
       tours.value = response
      })
    } catch (e) {
        console.error("Ошибка загрузки туров:", e);
    }
});
</script>

<template>
    <section class="hot-tours">
        <v-container>
            <v-card-title class="text-h6 text-md-h5 text-lg-h4">
                <strong>ГОРЯЩИЕ ТУРЫ</strong>
            </v-card-title>
            <v-card-text>ПОЙМАЙТЕ МОМЕНТ</v-card-text>

            <v-row class="ga-8" justify="center">
                <v-col
                    v-for="(tour) in tours"
                    :key="tour.id"
                    sm="6"
                    md="4"
                    lg="3"
                >
                    <v-sheet
                        class="rounded-xl d-flex flex-column justify-space-between pa-4"
                        height="340"
                        elevation="3"
                    >
                        <div class="d-flex justify-space-between">
                            <v-chip class="bg-transparent text-white" size="small">
                                {{ tour.days }} дн.
                            </v-chip>
                            <v-chip class="bg-transparent text-white" size="small">
                                {{ tour.price }}
                            </v-chip>
                        </div>

                        <div>
                            <div class="text-h6 font-weight-bold">
                                {{ tour.country }} • {{ tour.city }}
                            </div>
                            <div class="text-subtitle-2 font-weight-medium">
                                {{ tour.date }}
                            </div>
                            <div class="d-flex align-center mt-2">
                                <span class="mr-2">узнать подробнее</span>
                                <v-icon size="20">mdi-arrow-right-circle-outline</v-icon>
                            </div>
                        </div>
                    </v-sheet>
                </v-col>
            </v-row>
        </v-container>
    </section>
</template>

<style scoped>

</style>
