import NotFound from "./components/NotFound.vue";
import Home from "./components/Home.vue";
import Payment from "./components/Payment";

export default [
  {
    path: "/",
    component: Home,
    name: "home",
  },
  {
    path: "/payment",
    component: Payment,
  },
  {
    path: "*",
    component: NotFound,
  },
];
