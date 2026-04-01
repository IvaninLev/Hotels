import {createApp} from "vue";
import App from './App.vue'
import router from "./router/index.js";
import vuetify from "./plugins/vuetify.js";
import {createPinia} from "pinia";
import {createI18n} from "vue-i18n/dist/vue-i18n.cjs";
import english from "../src/langs/English.js";
import russian from "../src/langs/Russian.js";

const i18n = createI18n({
    legacy: false,
    locale: 'ru-RU',
    fallbackLocale:'en-US',
    messages:{
        'en-US': english,
        'ru-RU': russian
    }
})
const pinia = createPinia()
const app = createApp(App)

app
    .use(router)
    .use(vuetify)
    .use(pinia)
    .use(i18n)


app.mount('#app')
