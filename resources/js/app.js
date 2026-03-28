import {createApp} from "vue";
import App from './App.vue'
import router from "./router/index.js";
import vuetify from "./plugins/vuetify.js";
import {createPinia} from "pinia";

const pinia = createPinia()
const app = createApp(App)

app
    .use(router)
    .use(vuetify)
    .use(pinia)


app.mount('#app')

