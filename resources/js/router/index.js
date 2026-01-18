import {createRouter, createWebHistory} from "vue-router"
import DefaultLayout from "../layouts/DefaultLayout.vue";

const routes = [
    {
        path: '/',
        component: DefaultLayout,
        children: [
            {
                path: '',
                name: 'home',
                component: () => import('../pages/Home.vue')
            },
            {
                path: 'about',
                name: 'about',
                component: () => import('../pages/About.vue')
            },
            {
                path: 'buses',
                name: 'buses',
                component: () => import('../layouts/bus/index.vue')
            },
            {
                path:'bus/create',
                name:'create',
                component: () => import('../layouts/bus/create.vue')
            }
        ]
    },
]
const router = createRouter({
    routes,
    history: createWebHistory()
})

export default router
