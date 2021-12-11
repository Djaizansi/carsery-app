<template>
  <div>
  <b-navbar class="p-4">
    <template #brand>
      <b-navbar-item tag="router-link" :to="{ path: '/' }">
        <img
            src="https://raw.githubusercontent.com/buefy/buefy/dev/static/img/buefy-logo.png"
            alt="Lightweight UI components for Vue.js based on Bulma"
        >
      </b-navbar-item>
    </template>
    <template #start>
      <b-navbar-item>
        <router-link to="/louer">Louer</router-link>
      </b-navbar-item>
      <b-navbar-item href="#">
        Voitures
      </b-navbar-item>
    </template>

    <template #end>
      <b-navbar-item tag="div">
        <div class="buttons">
          <b-button
              name="register"
              label="S'inscrire"
              type="is-primary"
              icon-left="account-plus"
              @click="cardModal('register')" />
          <b-button
              variant="login"
              label="Connexion"
              icon-left="lock"
              @click="cardModal('login')" />
        </div>
      </b-navbar-item>
    </template>
  </b-navbar>
  </div>
</template>

<script>
  import Login from './Auth/Login';
  import Register from './Auth/Register';
  console.log(localStorage.getItem('user'));
  export default {
    methods: {
      cardModal(val) {
        console.log(val);
        this.$buefy.modal.open({
          parent: this,
          component: val === 'login' ? Login : Register,
          hasModalCard: true,
          customClass: 'custom-class custom-class-2',
          trapFocus: true
        })
      }
    }
  }
</script>

<style>

</style>
