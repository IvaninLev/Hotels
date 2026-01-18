<script setup >

import HeaderLayout from "../components/layout/HeaderLayout.vue";
import FooterLayout from "../components/layout/FooterLayout.vue";
</script>

<template>
    <v-app>
        <HeaderLayout/>
        <v-main>
        <router-view/>
        </v-main>
        <FooterLayout/>

    </v-app>
</template>

<style scoped>

</style>
