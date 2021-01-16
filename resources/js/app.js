require("./bootstrap");

require("alpinejs");

window.Vue = require("vue");

import App from "./components/App.vue";
import { router } from "./router";

const app = new Vue({
    router,
    render: h => h(App)
}).$mount("#app");
