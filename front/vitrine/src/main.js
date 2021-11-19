import Vue from "vue";
import VueRouter from "vue-router";
import App from "./App.vue";
import routes from "./routes";
import Buefy from "buefy";
import 'buefy/dist/buefy.css';
import './index.css'

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
