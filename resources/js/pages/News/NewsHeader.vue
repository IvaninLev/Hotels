<script setup>
import header from "../../../src/images/NewsHeader.svg"


</script>

<template>
    <section>
        <v-container fluid class="d-flex flex-column justify-center text-center pa-0">
            <v-img cover :src="header" align="center" width="100%">
                <div class="overlay d-flex align-center justify-center">
                    <div class="text-white text-center">
                        <h1 class="text-hero-heading font-weight-bold mb-2 text-uppercase">
                            новости
                        </h1>
                        <h2 class="text-h6 text-uppercase sub_text">
                            Самые свежие события и вдохновляющие истории из мира путешествий </h2>
                    </div>
                </div>
            </v-img>
        </v-container>
    </section>
</template>

<style scoped>
.overlay {
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.25);
}

.sub_text {
    max-width: 810px;
}
</style>
