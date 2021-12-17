<template>
  <div id="app" class="flex flex-col min-h-screen">
    <Navbar />
    <router-view class="flex-grow"></router-view>
    <Footer />
  </div>
</template>

<script>
  import Navbar from "./components/Navbar";
  import Footer from "./components/Footer";
  export default {
    mounted() {
      if(this.$cookies.get('user_get') && this.$cookies.get('token')){
        this.$store.commit('SET_USER', this.$cookies.get('user_get'));
      }
    },
    name: 'App',
    components: {
      Navbar,
      Footer
    }
  }
</script>

<style>
</style>
