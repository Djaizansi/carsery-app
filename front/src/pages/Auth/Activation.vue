<template>
  <div class="is-flex is-justify-content-center w-full" ref="element">
    <b-loading :is-full-page="false" v-model="loading" :can-cancel="false"></b-loading>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Activation",
  data: () => ({loading: false}),
  mounted() {
    this.loading = true;
    axios.post("http://localhost:3000/activation",{"tokenAccount":this.$route.params.token})
    .then(res => {
      console.log(res.status);
      if (res.status === 404){
        this.redirectionWithAlert('Une erreur est survenue','is-danger')
      }else if (res.status === 200){
        this.redirectionWithAlert('Votre compte est désormais activé','is-success')
      }
    })
  },
  methods: {
    redirectionWithAlert(message,type) {
      this.$buefy.toast.open({
        message: message,
        type: type
      })
      this.loading = !this.loading;
      this.$router.push('/');
    }
  }
}
</script>

<style>

</style>