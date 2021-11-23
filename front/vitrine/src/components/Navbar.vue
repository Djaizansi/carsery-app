<template>
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
      <b-navbar-item href="#">
        Home
      </b-navbar-item>
      <b-navbar-item href="#">
        Documentation
      </b-navbar-item>
    </template>

    <template #end>
      <b-navbar-item tag="div">
        <div class="buttons">
          <a class="button is-primary">
            <strong>Sign up</strong>
          </a>
          <b-button
                  label="Login"
                  type="is-primary"
                  icon-left="lock"
                  @click="cardModal" />
        </div>
      </b-navbar-item>
    </template>
  </b-navbar>
</template>

<script>
  import Login from './Login';
  console.log(localStorage.getItem('user'));
  export default {
    methods: {
      cardModal() {
        this.$buefy.modal.open({
          parent: this,
          component: Login,
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
