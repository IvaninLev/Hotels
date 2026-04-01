<script setup>
import Desert from '../../../src/images/desert.svg'
import { useI18n } from "vue-i18n";

const { t } = useI18n({ useScope: 'global' })
</script>

<template>
    <section class="choise" style=" height: 605px">
        <v-img cover :src="Desert">
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
                            {{ t('home.choiceTitle') }}
                        </div>

                        <div>
                            {{ t('home.choiceSubtitle') }}
                        </div>

                        <v-col class="d-flex flex-column align-end " cols="auto">
                            <v-text-field
                                :placeholder="t('home.name')"
                                variant="underlined"
                                density="compact"
                                hide-details
                                style="width: 144px"
                            />
                            <v-text-field
                                :placeholder="t('home.phone')"
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
                            {{ t('home.send') }}
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
