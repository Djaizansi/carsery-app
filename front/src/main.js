import Vue from "vue";
import VueRouter from "vue-router";
import App from "./App.vue";
import routes from "./routes";
import Buefy from "buefy";
import { StripePlugin } from "@vue-stripe/vue-stripe";
import "buefy/dist/buefy.css";
import "./index.css";

const options = {
  pk: process.env.VUE_APP_STRIPE_PUBLISHABLE_KEY,
  locale: process.env.VUE_APP_LOCALE,
};

Vue.use(StripePlugin, options);

Vue.use(Buefy);
Vue.use(VueRouter);

const router = new VueRouter({
  routes: routes,
  mode: "history",
});

Vue.config.productionTip = false;

new Vue({
  router,
  render: (h) => h(App),
}).$mount("#app");
