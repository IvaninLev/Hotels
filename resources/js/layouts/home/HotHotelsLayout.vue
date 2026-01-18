<script setup >

</script>

<template>
    <section class="hot-hotels" style="height: 898px;">
        <v-container>

            <div class=" mt-16" align="center">
                <v-card-title class="text-h6 text-md-h5 text-lg-h4"><strong>ПОПУЛЯРНЫЕ ОТЕЛИ</strong></v-card-title>
                <v-card-text>
                    УЮТ И РОСКОШЬ В ЛУЧШИЙ ОТЕЛЯХ МИРА
                </v-card-text>
                <v-row class="ga-8" justify="center">

                    <v-sheet
                        class="rounded-xl d-flex flex-column justify-space-between pa-4"
                        height="340"
                        width="544"
                        elevation="3"
                        :style="{
                            //добавить потом фор и логику вывода бг
      backgroundImage:'',
      backgroundSize: 'cover',
      backgroundPosition: 'center',
    }"
                    >
                        <!--добавить вывод данных из бд -->
                        <div class="">
                            <v-chip
                                variant="outlined"
                                size="small"
                                class="text-white position-absolute mt-3 mr-3"
                            >
                                <div class="text-subtitle-2 font-weight-medium">5</div>
                            </v-chip>
                        </div>

                        <div align="start" class="bg-transparent">
                            <v-card-title class="text-h6 font-weight-bold">ИТАЛИЯ • ВЕНЕЦИЯ</v-card-title>
                            <div class="d-flex  mt-2">
                                <span class="mr-2">узнать подробнее</span>
                                <v-icon size="20">mdi-arrow-right-circle-outline</v-icon>
                            </div>
                        </div>
                    </v-sheet>
                    <!-- полосу прокрута -->
                </v-row>
            </div>
        </v-container>
    </section>

</template>

<style scoped>

</style>
