import NotFound from "./components/NotFound.vue";
import Home from "./components/Home.vue";

export default [
  {
    path: "/",
    component: Home,
    name: "home",
  },
  {
    path: "*",
    component: NotFound,
  },
];
