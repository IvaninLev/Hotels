<script>
import mountians from "../../../src/images/mountians.svg"


</script>

<template>
    <section class="help-journey" style="height: 400px">

        <v-container
            fluid
            class="d-flex flex-column align-center justify-center text-center"
            style="width: 100%; height:500px"
        >

           <v-img :src="mountians">


                <v-card
                    class="rounded-xl pa-6"
                    style="width:1120px;"
                >
                    <v-row align="center" justify="space-between" no-gutters>
                        <div class="text-h5 w-25">
                            МЫ ПОМОЖЕМ СОЗДАТЬ ВАШЕ ПУТЕШЕСТВИЕ
                        </div>

                        <div>
                            Оставьте свой номер <br/>
                            и наш специалист поможет <br/>
                            вам с подбором тура
                        </div>

                        <v-col class="d-flex flex-column align-end" cols="auto">
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
            </v-img>
        </v-container>
    </section>
</template>

<style scoped>

</style>
