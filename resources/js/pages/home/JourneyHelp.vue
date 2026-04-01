<script setup>
import Image from "../../../src/images/mountians.svg"
import {ref} from "vue";
import { useI18n } from "vue-i18n";

const { t } = useI18n({ useScope: 'global' })
const activeMenu = ref(null);
const success = ref(false);
let successTimer = null;
const submit = () => {
    activeMenu.value = null;
    success.value = true;
    if (successTimer) clearTimeout(successTimer);
    successTimer = setTimeout(() => success.value = false, 5000);
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
                        {{ t('home.journeyHelpTitle') }}
                    </div>

                    <div>
                        {{ t('home.journeyHelpSubtitle') }}
                    </div>

                    <v-col class="d-flex flex-column align-end" cols="auto">
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
                        @click="submit"
                    >
                        {{ t('home.send') }}
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
