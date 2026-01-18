<script setup>
import Desert from '../../../src/images/desert.svg'

</script>

<template>
    <section class="choise" style="height: 605px">
        <v-img :src="Desert">
            <v-container
                fluid
                class="d-flex flex-column align-center justify-end text-center"
                style="width: 100%; height:605px"
            >


                <v-card
                    class="rounded-xl pa-6 mb-16"
                    style="width:1120px; height:133px"
                >
                    <v-row align="center" justify="space-between" no-gutters>
                        <div class="text-h5 ">
                            не определились<br/>
                            <span class="font-italic">с выбором?</span>
                        </div>

                        <div>
                            Оставьте свой номер <br/>
                            и наш специалист поможет <br/>
                            вам с подбором тура
                        </div>

                        <v-col class="d-flex flex-column align-end " cols="auto">
                            <v-text-field
                                placeholder="Имя"
                                variant="underlined"
                                density="compact"
                                hide-details
                                style="width: 144px"
                            />
                            <v-text-field
                                placeholder="Телефон"
                                variant="underlined"
                                density="compact"
                                hide-details
                                style="width: 144px"
                            />
                        </v-col>
                        <v-btn
                            color="red"
                            variant="flat"
                            class="rounded-pill px-6"
                        >
                            ОТПРАВИТЬ
                            <v-icon icon="mdi-arrow-bottom-right"></v-icon>
                        </v-btn>

                    </v-row>
                </v-card>

            </v-container>
        </v-img>
    </section>

</template>

<style scoped>

</style>
