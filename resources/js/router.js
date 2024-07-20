import {createRouter, createWebHistory} from "vue-router";
import {getMe} from "@/api/getMe.js";

const routes = [
    {
        path: "/",
        name: 'home',
        component: () => import("@/pages/HomePage.vue"),
    },
    {
        path: '/sign-up',
        name: 'sign-up',
        component: () => import("@/pages/SignUp.vue"),
    },
    {
        path: '/sign-in',
        name: 'sign-in',
        component: () => import("@/pages/SignIn.vue"),
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from) => {
    const user = await getMe();

    if (
        user === null &&
        to.name !== 'sign-in' &&
        to.name !== 'sign-up'
    ) {
        return {name: 'sign-in'}
    }
})

export default router;
