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
                component: () => import('../pages/home/index.vue'),
            },
            {
                path: 'hotels',
                name: 'hotels',
                component: () => import('../pages/hotels/index.vue')
            },

            {
                path: 'tour-selection',
                name: 'TourSelection',
                component: () => import('../pages/TourSelection/index.vue'),
                meta: {
                    breadcrumb: 'Подбор тура'
                }
            },
            {
                path: 'tour/:id',
                name: 'tourDetail',
                component: () => import('../pages/TourSelection/Details.vue'),
                meta: {
                    breadcrumb: 'Подробнее'
                },
            },
            {
                path: 'reviews',
                name: 'reviews',
                component: () => import('../pages/reviews/index.vue'),
                meta: {
                    breadcrumb: 'Отзывы'
                }
            },
            {
                path: 'news',
                name: 'news',
                component: () => import('../pages/News/index.vue'),
                meta: {
                    breadcrumb: "Новости"
                }
            }  ,
            {
                path: 'about',
                name: 'about',
                component: () => import('../pages/About/index.vue'),
                meta: {
                    breadcrumb: "Новости"
                }
            }

        ]
    },
]
const router = createRouter({
    routes,
    history: createWebHistory()
})

export default router
