import NotFound from "./pages/NotFound.vue";
import Home from "./pages/Home.vue";
import Payment from "./pages/Payment";
import Rent from "./pages/Rent";
import Activation from "./pages/Auth/Activation";
import Profile from "./pages/Profile";
import AddCars from "./pages/AddCars";
import store from "./store";
import VueCookie from "vue-cookie";
import ShowCarUser from "./pages/ShowCarUser";

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
    path: "/ajouter-vehicule",
    component: AddCars,
    name: "addCars",
    beforeEnter: (to, from, next) => {
      if(store.state.user === undefined || store.state.user.roles.includes('ROLE_CLIENT') || VueCookie.get('user_get') === null){
        next({name: 'home'});
      }
      next();
    }
  },
  {
    path: "/mes-voitures",
    component: ShowCarUser,
    name: "showCarUser",
    beforeEnter: (to, from, next) => {
      if(store.state.user === undefined || store.state.user.roles.includes('ROLE_CLIENT') || VueCookie.get('user_get') === null){
        next({name: 'home'});
      }
      next();
    }
  },
  {
    path: "/mon-profil",
    component: Profile,
    name: "profile",
    beforeEnter: (to, from, next) => {
      if(store.state.user === undefined || VueCookie.get('user_get') === null){
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
