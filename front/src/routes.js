import NotFound from "./components/NotFound.vue";
import Home from "./components/Home.vue";
import Payment from "./components/Payment";
import Rent from "./components/Rent";

export default [
  {
    path: "/",
    component: Home,
    name: "home",
  },
  {
    path: "/louer",
    component: Rent,
    name: "rent",
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
