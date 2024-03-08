require('./bootstrap');

import { createApp } from 'vue'

import App from './App.vue'

// Material Design
import '@mdi/font/css/materialdesignicons.css'

// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
    components,
    directives,
})

// Routes
import router from './routes'

// Vuex
import store from './store';

createApp(App).use(vuetify).use(router).use(store).mount("#app")
