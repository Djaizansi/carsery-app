import Vue from "vue";
import VueRouter from "vue-router";

const Foo = { template: "<div>foo</div>" };
const Bar = { template: "<div>bar</div>" };

const routes = [
  { path: "/foo", component: Foo },
  { path: "/bar", component: Bar },
];

const router = new VueRouter({
  routes: routes, // short for `routes: routes`
});

export default router;
