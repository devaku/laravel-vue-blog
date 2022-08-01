import { createRouter, createWebHistory } from "vue-router";
import axios from "axios";

// Pages
import postPage from "../pages/posts/_id.vue";
import DashboardPage from "../pages/dashboard/index.vue";
import LoginPage from "../pages/dashboard/Login.vue";
import HomePage from "../pages/index.vue";

// Utilies
import NotFoundPage from "../pages/utilities/404.vue";

const routes = [
    { path: "/", component: HomePage, name: "home" },
    {
        path: "/posts/:id",
        name: "details",
        component: postPage,
        props: true,
    },

    {
        path: "/login",
        name: "login",
        component: LoginPage,
        beforeEnter: (to, form, next) => {
            axios
                .get("/api/authenticated")
                .then(() => {
                    next({ name: "home" });
                    return;
                })
                .catch(() => {
                    next();
                    return;
                });
        },
    },
    {
        path: "/dashboard",
        name: "dashboard",
        component: DashboardPage,
        beforeEnter: (to, form, next) => {
            axios
                .get("/api/authenticated")
                .then(() => {
                    next();
                })
                .catch(() => {
                    next({ name: "login" });
                    return;
                });
        },
    },

    // 404 Page
    { path: "/:pathMatch(.*)*", component: NotFoundPage },
];

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = createRouter({
    // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
    // linkActiveClass: "fw-bold",
    history: createWebHistory(),
    routes,
});

export default router;
