<script setup>
import Image from "../../../src/images/mountians.svg"

const submit = () => {
    // TODO: hook into form submit once validation logic is added
}
</script>

<template>
    <section class="help-journey" style="height:auto;">

        <v-img cover fluid :src="Image" align="center" width="100%">
            <v-card
                class="rounded-xl pa-6"
                style="width:1120px; margin:90px;"
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
                        @click="submit"
                    >
                        ОТПРАВИТЬ
                        <v-icon icon="mdi-arrow-bottom-right"></v-icon>
                    </v-btn>

                </v-row>
            </v-card>
        </v-img>
    </section>
</template>

<style scoped>
.help-journey{

}
</style>
