<script setup>
import {ref, watch, onBeforeUnmount} from 'vue';
import {useRoute} from "vue-router";
import RecallModal from "../modals/RecallModal.vue";
import SuccessModal from "../modals/SuccessModal.vue";

const route = useRoute()
const show = ref(false);
const phone = ref(false);
const address = ref(false);
const activeMenu = ref(null);
const success = ref(false);
let successTimer = null;

const toggleMenu = (name) => {
    activeMenu.value = activeMenu.value === name ? null : name;
}

const number = ref([
    '+7 (223) 433-99-98',
    '+7 (925) 826-33-97'
]);


watch(() => route.path, () => {
    show.value = false;

})

const handleRecallSubmit = () => {
    activeMenu.value = null;
    success.value = true;
    if (successTimer) clearTimeout(successTimer);
    successTimer = setTimeout(() => success.value = false, 5000);
}

onBeforeUnmount(() => {
    if (successTimer) clearTimeout(successTimer);
});
</script>

<template>
    <div style="position: relative;">
        <v-app-bar style="position:absolute; " flat height="80" class="px-6 bg-white shadow-sm" elevation="2">

            <router-link to="/" class="d-flex align-center text-h5 font-weight-bold text-red text-decoration-none">
                Anex <span class="ml-1 text-deep-purple-accent-4"><v-icon>mdi-heart-outline</v-icon></span>
            </router-link>

            <v-spacer/>

            <div class="d-none d-md-flex align-center">

                <router-link to="/tour-selection" class="nav-link mx-4 text-black">
                    ПОДБОР ТУРА
                </router-link>

                <span class="nav-link mx-4 text-black" style="cursor:pointer" @click="show = !show">
                      ГОРЯЩИЕ ТУРЫ
                </span>

                <router-link to="#" class="nav-link mx-4 text-black">
                    СТРАНЫ
                </router-link>

                <router-link to="/hotels" class="nav-link mx-4 text-black">
                    ОТЕЛИ
                </router-link>

            </div>


            <v-spacer/>

            <v-btn variant="outlined" @click="toggleMenu('recall')" rounded class="text-black" style="font-weight:600;">
                ОСТАВИТЬ ЗАЯВКУ
            </v-btn>
            <v-btn @click="toggleMenu('phone')">
                <v-icon class="mx-2 text-black">mdi-phone</v-icon>
            </v-btn>
            <v-btn @click="toggleMenu('address')">
                <v-icon class="mx-2 text-black">mdi-map-marker</v-icon>
            </v-btn>
            <v-btn @click="show = !show" icon class="mx-2 text-black">
                <v-icon>mdi-menu</v-icon>
            </v-btn>
        </v-app-bar>
        <v-expand-transition>
            <v-card
                v-if="activeMenu === 'phone'"
                class="mini-box"
            >
                <div>
                    <span> {{ number[0] }}</span>
                </div>
                <span> {{ number[1] }}</span>
            </v-card>
        </v-expand-transition>
        <v-expand-transition v-if="activeMenu === 'address'">
            <v-card class="mini-box pa-4">
                <div>
                    <span style="">Highway 5, Drive 9, Building 64(second floor)</span>
                </div>
            </v-card>
        </v-expand-transition>
        <v-expand-transition>

            <div
                v-if="show"
                style="
                  position:absolute;
                  top:80px;
                  left:0;
                  width:100%;
                  height:305px;
                  background:#f8f8f8;
                  border-top:1px solid #ddd;
                  z-index:300;
                  padding-top:40px;
                "
            >
                <v-container>
                    <v-row class="text-center">

                        <v-col cols="12" md="4">
                            <h4 style="font-weight:700; margin-bottom:8px">ПОПУЛЯРНЫЕ СТРАНЫ</h4>
                            <span>There must be a countries(in work)</span>
                        </v-col>

                        <v-col cols="12" md="4">
                            <h4 style="font-weight:700; margin-bottom:8px">ТУРИСТАМ</h4>
                            <!--                            <router-link to="/countries" class="sub-link">Страны</router-link>-->
                            <router-link to="/hotels" class="sub-link">Отели</router-link>
                            <router-link to="/tour-selection" class="sub-link">Подбор тура</router-link>
                            <!--                            <router-link to="/hot-tours" class="sub-link">Горящие туры</router-link>-->
                            <!--                            <router-link to="/how-to-buy" class="sub-link">Как купить и оплатить тур</router-link>-->
                        </v-col>

                        <v-col cols="12" md="4">
                            <h4 style="font-weight:700; margin-bottom:8px">КОМПАНИЯ</h4>
                            <router-link to="/about" class="sub-link">О нас</router-link>
                            <router-link to="/reviews" class="sub-link">Отзывы</router-link>
                            <!--                            <router-link to="/contacts" class="sub-link">Контакты</router-link>-->
                            <router-link to="/news" class="sub-link">Новости</router-link>
                            <!--                            <router-link to="/priority" class="sub-link">Priority</router-link>-->
                            <!--                            <router-link to="/career" class="sub-link">Карьера</router-link>-->
                        </v-col>

                    </v-row>
                </v-container>
            </div>
        </v-expand-transition>
        <recall-modal
            v-if="activeMenu === 'recall'"
            @close="activeMenu = null"
            @submit="handleRecallSubmit"
        />
        <success-modal v-if="success" @close="success = false"/>

    </div>
</template>
<style scoped>
.mini-box {
    border-radius: 30px;
    position: absolute;
    top: 80px;
    right: 24px;
    width: auto;
    max-width: 266px;
    background: #f8f8f8;
    border: 1px solid #ddd;
    z-index: 1;
    padding: 16px;
}

.nav-link {
    font-weight: 600;
    font-size: 0.95rem;
    text-decoration: none;
    transition: color 0.2s ease;
}

.sub-link {
    display: block;
    color: gray;
    text-decoration: none;
}

.sub-link:hover {
    color: red;
}

.nav-link:hover {
    color: red;
}

.nav-link:active {
    color: red
}

</style>
