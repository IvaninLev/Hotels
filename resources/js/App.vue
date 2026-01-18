<script setup>
import {ref} from "vue";
import HeaderLayout from "./components/layout/HeaderLayout.vue";
import FooterLayout from "./components/layout/FooterLayout.vue";

const drawer = ref(false)
</script>

<template>

    <router-view/>

</template>

<style scoped>

</style>
