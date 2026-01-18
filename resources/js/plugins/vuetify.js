import '@mdi/font/css/materialdesignicons.css'
import '../../css/app.scss'
import {createVuetify} from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import {aliases, mdi} from 'vuetify/iconsets/mdi'

const vuetify = createVuetify({
    components,
    directives,
    icons:{
        defaultSet:"mdi",
        aliases,
        sets:{
            mdi
        }
    },
    theme:{
        themes:{
            light:{
                colors:{
                    "base-red": '#EC1C24',
                }
            }
        }
    }
})

export default vuetify
