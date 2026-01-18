import {createApp} from "vue/dist/vue.esm-bundler.js";
import createHotel from './src/hotel/create.vue'
import vuetify from "../plugins/vuetify.js";


const app = createApp({})

app.component('createHotel', createHotel)

app.use(vuetify)

app.mount('#crud')
