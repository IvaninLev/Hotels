<script setup >
import midnightImg from '../../../src/images/midnight.svg'

</script>

<template>
    <section class="dreamTravel">
        <v-container
            fluid
            class="d-flex flex-column align-center justify-center text-center pa-0"
            min-height="100vh"
        >
            <v-img :src="midnightImg" align="center" cover width="100%">
                <div class="text-white mb-6 w-75 mt-16">
                    <h1 class="text-hero-heading font-weight-bold mb-2">ПУТЕШЕСТВИЯ МЕЧТЫ</h1>
                    <h2 class="text-h6 pl">ВЫБЕРИ СВОЮ</h2>
                </div>
                <v-card class="rounded-pill mt-16" width="930">
                    <v-container class="pa-0">

                        <v-row no-gutters justify="center" align="center" class="pa-3 pb-2">
                            <v-col cols="12" md="2" class="pl-4">
                                <v-text-field
                                    bg-color="transparent"
                                    base-color="transparent"
                                    variant="plain"
                                    density="compact"
                                    label="Откуда"
                                    class=" border-e-sm"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field
                                    bg-color="transparent"
                                    base-color="transparent"
                                    variant="plain"
                                    density="compact"
                                    label="Куда"
                                    class=" px-1 border-e-sm"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field
                                    bg-color="transparent"
                                    base-color="transparent"
                                    variant="plain"
                                    density="compact"
                                    label="Вылет"
                                    class=" px-1 border-e-sm"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field
                                    bg-color="transparent"
                                    base-color="transparent"
                                    variant="plain"
                                    density="compact"
                                    label="На сколько"
                                    class=" px-1 border-e-sm"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field
                                    bg-color="transparent"
                                    base-color="transparent"
                                    variant="plain"
                                    density="compact"
                                    label="Туристы"
                                    class=" px-1 border-e-sm"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="2" class="d-flex align-center ">
                                <v-btn color="base-red" class="text-white rounded-pill mb-3 " block>
                                    ПОДОБРАТЬ
                                    <v-icon icon="mdi-arrow-bottom-right"></v-icon>
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card>
            </v-img>

        </v-container>
    </section>
</template>

<style scoped>

</style>
