<script setup>
import AppHeader from "../components/common/AppHeader.vue";
import AppFooter from "../components/common/AppFooter.vue";
</script>

<template>
    <v-app>
        <AppHeader/>

        <v-main>
            <router-view/>
        </v-main>

        <AppFooter/>
    </v-app>
</template>
