require('./bootstrap');

import Vue from 'vue'
import store from './store'
import VueRouter from 'vue-router'
Vue.use(VueRouter)
import routes from './routes'

import Vuetify from 'vuetify'
Vue.use(Vuetify)

import App from './components/App.vue'

const app = new Vue({
    el: '#app',
    store,
    theme: { dark: true },
    components: { App },
    router: new VueRouter(routes),
    vuetify: new Vuetify()
})
