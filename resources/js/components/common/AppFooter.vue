    <script setup>
const links = [
    { text: 'Подбор тура', to: '/tour-selection' },
    { text: 'Отзывы', to: '/reviews' },
    { text: 'О нас', to: '/about' },
];
</script>

<template>
    <v-footer color="#1A1A1A" height="461" class="pa-0 d-flex flex-column justify-space-between rounded-t-xl">
        <v-container class="pt-10">
            <v-row align="center" justify="space-between">
                <v-col cols="12" md="4" class="d-flex align-center">
                    <router-link to="/" class="text-h4 font-weight-bold white--text">
                        Anex <span style="color: red;"></span>
                    </router-link>
                </v-col>

                <v-col cols="12" md="8" class="d-flex align-center justify-end">
                    <span class="white--text mr-4 ">Узнавайте о горячих турах первыми</span>
                    <v-text-field
                        placeholder="Введите почту"
                        hide-details
                        variant="outlined"
                        density="comfortable"
                        color="white"
                        class="mr-2"
                        style="max-width: 250px;"
                    ><span class="mdi mdi-email-outline"></span>
                    </v-text-field>
                    <v-btn color="red" class="white--text mdi mdi-arrow-right"></v-btn>
                </v-col>
            </v-row>

            <v-divider class="my-6" color="grey darken-2"></v-divider>

            <v-row justify="center">
                <v-col cols="auto" v-for="link in links" :key="link.text">
                    <router-link :to="link.to" class="white--text text-uppercase text-body-2">
                        {{ link.text }}
                    </router-link>
                </v-col>
            </v-row>

            <v-divider class="my-6" color="grey darken-2"></v-divider>

        </v-container>

        <v-container class="py-6 grey--text text--lighten-1 text-center">
            <div class="d-flex justify-center mb-4">
                <v-btn icon variant="text" class="white--text">
                    <span class="mdi mdi-instagram"></span>
                </v-btn>
                <v-btn icon variant="text" class="white--text">
                    <span class="mdi mdi-facebook"></span>
                </v-btn>
                <v-btn icon variant="text" class="white--text">
                    <span class="mdi mdi-telegram"></span>
                </v-btn>
                <v-btn icon variant="text" class="white--text">
                    <span class="mdi mdi-vk"></span>
                </v-btn>
            </div>
            <div>© 2025 Anex Tour · Туристическая компания</div>
        </v-container>
    </v-footer>
</template>

<style>
.v-footer a {
    color: white;
    text-decoration: none ;
}

.v-footer a:hover {
    color: #ff4d4d ;
}

</style>
