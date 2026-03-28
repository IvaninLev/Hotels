<script setup>
import sea from '../../../src/images/david-straight.svg'


</script>

<template>
    <section>
        <v-img
            :src="sea"
            cover
            width="100%"
            height="470px"
        >
            <div class="overlay d-flex align-center justify-center">
                <div class="text-white text-center">
                    <h1 class="text-hero-heading font-weight-bold mb-2 text-uppercase">
                        отзывы
                    </h1>
                    <h2 class="text-h6 text-uppercase sub_text">
                        Истории наших путешественников: Вдохновение для вашего следующего приключения
                    </h2>
                </div>
            </div>
        </v-img>
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
