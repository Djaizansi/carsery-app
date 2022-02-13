<template>
  <div>
  <b-navbar class="p-4">
    <template #brand>
      <b-navbar-item tag="router-link" :to="{ path: '/' }">
        <img
            src="../../public/carsery.png"
            alt="carsery"
        >
      </b-navbar-item>
    </template>
    <template #start>
      <b-navbar-item v-if="user === '' || (!user.roles.includes('ROLE_ADMIN'))">
        <b-icon icon="shopping"></b-icon>
        <router-link  to="/louer">Louer</router-link>
      </b-navbar-item>
      <b-dropdown
          append-to-body
          aria-role="menu"
          scrollable
          max-height="200"
          trap-focus
          v-if="user && (user.roles.includes('ROLE_PRO') || user.roles.includes('ROLE_ADMIN'))"
      >
        <template #trigger>
          <a
              class="navbar-item"
              role="button">
            <b-icon icon="car"></b-icon>
            <span>Véhicule</span>
            <b-icon icon="menu-down"></b-icon>
          </a>
        </template>
        <b-dropdown-item class="space-x-1" v-if="user && (user.roles.includes('ROLE_PRO') || user.roles.includes('ROLE_ADMIN'))">
          <b-icon icon="car-2-plus"></b-icon>
          <router-link to="/ajouter-vehicule">Ajouter un véhicule</router-link>
        </b-dropdown-item>

        <b-dropdown-item class="space-x-1" v-if="user && (user.roles.includes('ROLE_ADMIN'))">
          <b-icon icon="car-settings"></b-icon>
          <router-link to="/ajouter-vehicule/type">Ajouter un véhicule type</router-link>
        </b-dropdown-item>

        <b-dropdown-item class="space-x-1" v-if="user && (user.roles.includes('ROLE_PRO') || user.roles.includes('ROLE_ADMIN'))">
          <b-icon icon="car-cog"></b-icon>
          <router-link to="/mes-voitures">Mes véhicules</router-link>
        </b-dropdown-item>
      </b-dropdown>

      <b-navbar-item v-if="user && (user.roles.includes('ROLE_PRO') || user.roles.includes('ROLE_CLIENT'))">
        <b-icon icon="car-key"></b-icon>
        <router-link to="/mes-locations">Mes locations</router-link>
      </b-navbar-item>

      <b-navbar-item v-if="user && user.roles.includes('ROLE_ADMIN')">
        <b-icon icon="car-multiple"></b-icon>
        <router-link to="/gestion-marketplace">Gestion Marketplace</router-link>
      </b-navbar-item>
    </template>

    <template #end>
      <b-navbar-item tag="div">
        <div class="buttons">
          <div class="user" v-if="!user">
            <b-button
                name="register"
                label="S'inscrire"
                type="is-primary"
                icon-left="account-plus"
                @click="cardModal('register')"
            />
            <b-button
                variant="login"
                label="Connexion"
                icon-left="lock"
                @click="cardModal('login')"
            />
          </div>
          <div class="user-connected" v-else>
            <b-button>
              <router-link to="/mon-profil">Mon profil</router-link>
            </b-button>
            <b-button
                name="logout"
                type="is-danger"
                icon-left="logout"
                @click="logout"
            />
          </div>
        </div>
      </b-navbar-item>
    </template>
  </b-navbar>
  </div>
</template>

<script>
  import Login from '../pages/Auth/Login';
  import Register from '../pages/Auth/Register';
  export default {
    computed: {
      user () {
        return this.$store.state.user;
      }
    },
    methods: {
      cardModal(val) {
        this.$buefy.modal.open({
          parent: this,
          component: val === 'login' ? Login : Register,
          hasModalCard: true,
          customClass: 'custom-class custom-class-2',
          trapFocus: true
        })
      },
      logout(){
        ['user_get','token','refresh_token'].map(cookie => this.$cookie.delete(cookie));
        this.$store.commit('SET_USER',"");
        this.$buefy.toast.open({
          message: 'Vous êtes déconnecté',
          type: 'is-success'
        });
        if(this.$route.name !== 'home') this.$router.push('/');
      }
    }
  }
</script>

<style>

</style>
