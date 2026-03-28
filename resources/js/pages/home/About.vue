<script setup>
import {ref} from "vue";
import woman from "../../../src/images/woman-working.png"
import bridge from "../../../src/images/bridge.png"

const items = ref([
    {
        title: 'Главная',
        disabled: false,
        href: '/',
    },
    {
        title: 'О нас',
        disabled: true,
        href: '/about'
    }
])
</script>

<template>
    <section class="about-section">
        <v-container>

                <div class="decorative-text mt-13">We</div>
            <div class="text-center mb-12 position-relative">
                <div style="margin:90px;">
                    <h2 class="text-h3 font-weight-bold mb-2">О НАС</h2>
                    <p class="text-subtitle-1 text-grey-darken-1 text-uppercase">Вдохновляем мир на путешествия</p>
                </div>
            </div>

            <v-row class="content-wrapper">
                <v-col cols="12">
                    <v-row>
                        <v-col cols="12" md="6" class="left-top">
                            <p class="intro-text">
                                <strong class="main-heading">МЫ</strong>
                                — команда профессионалов, влюблённых в
                                искусство путешествий. Наша история началась
                                с мечты о том, чтобы сделать каждое путешествие
                                незабываемым, каждое приключение уникальным.
                            </p>
                            <p class="mission-text">
                                Наша миссия – сделать путешествия доступными и незабываемыми.
                                Мы предлагаем вам не просто туры, а волшебные истории, которые
                                будут жить в вашем сердце навсегда. Независимо от того, ищете ли
                                вы релакса на пляже, культурные изыски или экстремальные
                                приключения, мы создадим для вас оптимальное путешествие,
                                подстроенное под ваши уникальные желания.
                            </p>
                        </v-col>

                        <v-col cols="12" md="6" class="right-top">
                            <v-img
                                cover
                                fluid
                                :src="woman"
                                class="woman-image"
                            >
                            </v-img>
                        </v-col>
                    </v-row>
                </v-col>

                <v-col cols="12" class="bottom-section">
                    <v-row>
                        <v-col cols="12" md="6" class="left-bottom">
                            <v-img
                                :src="bridge"
                                cover
                                rounded="xl"
                                width="400px"
                            >
                            </v-img>
                        </v-col>
                        <v-col cols="12" md="6" class="right-bottom">
                            <p class="bridge-description">
                                Мы гордимся нашей командой опытных
                                специалистов, каждый из которых разделяет
                                страсть к туризму и стремление сделать ваше
                                путешествие незабываемым. Мы внимательно
                                следим за последними тенденциями в
                                индустрии, чтобы предложить вам только
                                лучшие и самые актуальные варианты.
                            </p>
                            <p class="right-description">
                                Присоединяйтесь к нам в этом
                                захватывающем путешествии! Мы готовы
                                подарить вам моменты радости, вдохновения
                                и удивления в каждом уголке нашего
                                удивительного мира.
                            </p>
                        </v-col>

                    </v-row>
                </v-col>
            </v-row>
        </v-container>
    </section>
</template>

<style scoped>
.decorative-text {
    position: absolute;
    left: 45%;
    transform: translateY(-50%);
    font-size: 100px;
    font-weight: 300;
    color: rgba(0, 0, 0, 0.03);
}

.main-heading {
    font-family: 'Fira Code Retina';
    font-size: 90px;
    font-weight: 200;
    line-height: 0.9;
    color: #000;
}

.left-bottom {
    padding: 0;
    margin: 0;
}


.intro-text {
    font-size: 16px;
    line-height: 1.6;
    color: #333;
    margin-bottom: 20px;
}

.mission-text {
    font-size: 14px;
    line-height: 1.7;
    color: #555;
    margin-top: 20px;
}


.woman-image {
    border-radius: 12px;
    height: 350px;
}


.bridge-description {
    font-size: 14px;
    line-height: 1.7;
    color: #555;
}

.right-bottom {
    display: flex;
    align-items: center;
}

.right-description {
    font-size: 14px;
    line-height: 1.7;
    color: #555;
}

@media (max-width: 960px) {
    .left-top, .right-top, .left-bottom, .right-bottom {
        padding-left: 15px;
        padding-right: 15px;
    }

    .main-heading {
        font-size: 80px;
    }

    .woman-image {
        height: 280px;
    }


    .bottom-section {
        margin-top: 40px;
    }
}
</style>
