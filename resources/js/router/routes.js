import { createRouter, createWebHistory } from "vue-router";
import axios from "axios";

// Pages
import postPage from "../pages/posts/_id.vue";
import addEditPage from "../pages/posts/AddEdit.vue";
import DashboardPage from "../pages/dashboard/index.vue";
import LoginPage from "../pages/dashboard/Login.vue";
import RegisterPage from "../pages/dashboard/Register.vue";
import HomePage from "../pages/index.vue";

// Utilies
import NotFoundPage from "../pages/utilities/404.vue";

const routes = [
    { path: "/", component: HomePage, name: "home" },
    {
        path: "/posts/:id",
        name: "details",
        component: postPage,
        // props: true,
    },
    {
        path: "/posts/:method/:id",
        name: "modifyPost",
        component: addEditPage,
        // props: true,
        beforeEnter: (to, form, next) => {
            const { method } = to.params;
            if (method == "edit" || method == "add") {
                next();
            } else {
                next({ name: "404" });
            }
        },
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
        path: "/register",
        name: "register",
        component: RegisterPage,
        beforeEnter: (to, form, next) => {
            axios
                .get("/api/authenticated")
                .then(() => {
                    next({ name: "dashboard" });
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
    { path: "/:pathMatch(.*)*", component: NotFoundPage, name: "404" },
];

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = createRouter({
    // linkActiveClass: "fw-bold",
    history: createWebHistory(),
    routes,
});

export default router;
