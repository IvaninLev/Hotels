<script setup>
import unsplashImg from '../../../src/images/unsplash.svg'
import {onMounted, ref, watch} from "vue";
import {useSearchStore} from "../../stores/useSearchStore.js";
import FilterService from "../../services/FilterService.js";
import {useRoute, useRouter} from "vue-router";

const search = useSearchStore();
const route = useRoute()
const router = useRouter()

const filters = ref({
    searchQuery: '',
    from: "",
    toPlace: "",
    flightDate: "",
    duration: null,
    tourists: null
})

const handleSearch = async () => {
    await router.replace({query: {...filters.value}})
}

watch(
    () => route.query,
    async (query) => {
        if (Object.keys(query).length === 0) return

        filters.value = {
            ...filters.value,
            ...query,
        }

        const results = await FilterService.getFilteredTours(filters.value)
        search.setTours(results)
    },
    {deep: true, immediate: true}
)
</script>

<template>
    <section class="TourHeaderLayout">
        <v-container
            fluid
            class="d-flex flex-column align-center justify-center text-center pa-0"
            min-height="100vh"
        >
            <v-img :src="unsplashImg" align="center" cover width="100%">
                <div class="text-white mb-6 w-75 mt-16">
                    <h1 class="text-hero-heading font-weight-bold mb-2">подбор тура</h1>
                    <h2 class="text-h4 pl">Идеальное путешествие начинается здесь</h2>
                </div>
                <v-card class="rounded-pill mt-16" width="930">
                    <v-container class="pa-0">

                        <v-row no-gutters justify="center" align="center" class="pa-3 pb-2">
                            <v-col cols="12" md="2" class="pl-4">
                                <v-text-field
                                    bg-color="transparent"
                                    base-color="transparent"
                                    variant="plain"
                                    v-model="filters.from"
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
                                    v-model="filters.toPlace"
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
                                    v-model="filters.flightDate"
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
                                    v-model="filters.duration"
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
                                    v-model="filters.tourists"
                                    class=" px-1 border-e-sm"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="2" class="d-flex align-center ">
                                <v-btn color="base-red" @click="handleSearch" class="text-white rounded-pill mb-3 " block>
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
