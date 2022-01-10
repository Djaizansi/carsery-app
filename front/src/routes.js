import NotFound from "./pages/NotFound.vue";
import Home from "./pages/Home.vue";
import Payment from "./pages/Payment";
import Rent from "./pages/Rent";
import Activation from "./pages/Auth/Activation";
import Profile from "./pages/Profile";
import VueCookie from "vue-cookie";

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
    path: "/activation/:token",
    component: Activation,
    name: "activation",
  },
  {
    path: "/mon-profil",
    component: Profile,
    name: "profile",
    beforeEnter: (to, from, next) => {
      if(VueCookie.get('user_get') === null){
        next({name: 'home'});
      }
      next();
    }
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
