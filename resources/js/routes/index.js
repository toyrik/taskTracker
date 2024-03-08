import { createRouter, createWebHistory } from "vue-router";
import store from '../store'

import Dashboard from '../pages/Dashboard.vue'
import Login from '../pages/Login.vue'

const routes = [
    {
        path: '/',
        name: 'index',
        component: Login,
        meta : { auth : false }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta : { auth : false }
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta : { auth : true }
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    if( to.meta.auth && !store.getters.GET_IS_AUTHENTICATED ) {
        next({ name: 'login' })
    } else if( !to.meta.auth && store.getters.GET_IS_AUTHENTICATED ) {
        next({ name: 'dashboard' })
    } else {
        next()
    }
})

export default router
