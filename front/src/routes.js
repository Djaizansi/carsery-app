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
import ManageMarketPlace from "./pages/ManageMarketPlace";
import GestionCarsUser from "./pages/GestionCarsUser";
import Thanks from "./pages/Thanks";
import ShowRentUser from "./pages/ShowRentUser";
import ShowRentUserByCar from "./pages/ShowRentUserByCar";

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
    beforeEnter: (to, from, next) => {
      if(store.state.user !== '' && store.state.user.roles.includes('ROLE_ADMIN')){
        next({name: 'home'});
      }
      next();
    }
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
        //checkTokenValid(next);
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
        //checkTokenValid(next);
        next({name: 'home'});
      }
      next();
    }
  },
  {
    path: "/mes-locations",
    component: ShowRentUser,
    name: "showRentUser",
    beforeEnter: (to, from, next) => {
      if(store.state.user === undefined || store.state.user.roles.includes('ROLE_ADMIN') || VueCookie.get('user_get') === null){
        next({name: 'home'});
      }
      next();
    }
  },
  {
    path: "/mes-locations/:id",
    component: ShowRentUserByCar,
    name: "showRentUser",
    beforeEnter: (to, from, next) => {
      if(store.state.user === undefined || store.state.user.roles.includes('ROLE_ADMIN') || VueCookie.get('user_get') === null){
        //checkTokenValid(next);
        next({name: 'home'});
      }
      next();
    }
  },
  {
    path: "/gestion-marketplace",
    component: ManageMarketPlace,
    name: "ManageMarketPlace",
    beforeEnter: (to, from, next) => {
      if(store.state.user === undefined || !store.state.user.roles.includes('ROLE_ADMIN') || VueCookie.get('user_get') === null){
        //checkTokenValid(next);
        next({name: 'home'});
      }
      next();
    }
  },
  {
    path: "/gestion-marketplace/cars",
    component: GestionCarsUser,
    name: "gestionMarketPlaceByCarsUser",
    beforeEnter: (to, from, next) => {
      if(store.state.user === undefined || !store.state.user.roles.includes('ROLE_ADMIN') || VueCookie.get('user_get') === null || to.params.user === undefined){
        //checkTokenValid(next);
        next({name: 'ManageMarketPlace'});
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
        //checkTokenValid(next);
        next({name: 'home'});
      }
      next();
    }
  },
  {
    path: "/payment",
    component: Payment,
    name: "payment",
    beforeEnter: (to, from, next) => {
      if(store.state.user === undefined || VueCookie.get('user_get') === null){
        next({name: 'home'});
      }
      next();
    }
  },
  {
    path: "/merci",
    component: Thanks,
    name: "thanks",
    beforeEnter: (to, from, next) => {
      if(store.state.user === undefined || VueCookie.get('user_get') === null || to.params.check === undefined){
        //checkTokenValid(next);
        next({name: 'home'});
      }
      next();
    }
  },
  {
    path: "*",
    component: NotFound,
  },
];

function checkTokenValid(next){
  if(VueCookie.get('token') === 'undefined'){
    ['user_get','token','refresh_token'].map(cookie => VueCookie.delete(cookie));
    store.commit('SET_USER','');
    localStorage.removeItem('rent');
    next({name: 'home'});
  }
}
