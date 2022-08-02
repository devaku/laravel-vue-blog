import "./bootstrap";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.min.js";
import { createApp } from "vue";
import App from "./App.vue";

import router from "./router/routes.js";

import VueCookies from "vue-cookies";
// default options config: { expires: '1d', path: '/', domain: '', secure: '', sameSite: 'Lax' }

let vueApp = createApp(App);
vueApp.use(VueCookies, { expire: "7d" });
vueApp.use(router);
vueApp.mount("#app");
