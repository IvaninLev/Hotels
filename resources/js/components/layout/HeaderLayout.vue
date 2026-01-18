<script setup>
import {ref} from 'vue'

const drawer = ref(false)
</script>

<template>
    <v-app-bar
        color="white"
        height="80"ОТЕЛИ
        flat
        class="px-6 shadow-sm"
    >
        <router-link to="/" class="d-flex align-center text-red font-weight-bold text-h5"> Anex <span
            class="text-deep-purple-accent-4 ml-1">❤</span></router-link>

        <v-spacer></v-spacer>

        <div class="d-none d-md-flex align-center">
            <router-link
                to="#"
                class="mx-4 nav-link"
            >
                ПОДБОР ТУРА
            </router-link>
            <router-link
                to="#"
                class="mx-4 nav-link"
            >
                ГОРЯЩИЕ ТУРЫ
            </router-link>
            <router-link
                to="#"
                class="mx-4 nav-link"
            >
                СТРАНЫ
            </router-link>
            <router-link
                to="about"
                class="mx-4 nav-link"
            >
                ОТЕЛИ
            </router-link>
            <router-link
                to="buses"
                class="mx-4 nav-link"
            >
                АВТОБУСЫ
            </router-link>
        </div>

        <v-spacer></v-spacer>

        <v-btn outlined class="mx-2 text-black">ОСТАВИТЬ ЗАЯВКУ</v-btn>
        <v-icon class="mx-2 text-black">mdi-phone</v-icon>
        <v-icon class="mx-2 text-black">mdi-map-marker</v-icon>
        <v-btn icon class="mx-2 text-black">
            <v-icon>mdi-menu</v-icon>
        </v-btn>
    </v-app-bar>
</template>

<style scoped>
a {
    text-decoration: none;
}



.nav-link {
    color: black;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    transition: color 0.2s;
}

.nav-link:hover {
    color: #EC1C24;
}
</style>
