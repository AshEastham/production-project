import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import App from './views/App'
import Welcome from './views/Welcome'
import Webapp from './views/Webapp'
import ServiceBar from './components/ServiceBar'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Welcome
        },
        {
            path: '/webapp',
            name: 'webapp',
            component: Webapp
        },
        {
            path: '/playlist',
            name: 'playlist',
            component: Playlist
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    ServiceBar,
    Welcome
});