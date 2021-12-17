import NotFound from "./pages/NotFound.vue";
import Home from "./pages/Home.vue";
import Payment from "./pages/Payment";
import Rent from "./pages/Rent";

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
