import NotFound from "./components/NotFound.vue";
import Payment from "./components/payment.vue";

export default [
  {
    path: "/",
    component: Payment,
  },
  {
    path: "*",
    component: NotFound,
  },
];
