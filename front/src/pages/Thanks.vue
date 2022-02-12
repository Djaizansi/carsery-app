<template>
  <div class="flex flex-col items-center justify-center px-5 space-x-5 mb-5">
    <h1 class="text-2xl mb-10"><b-icon icon="check-bold" size="is-medium" type="is-success" class="mr-3"></b-icon>Merci pour votre commande !</h1>
    <p class="text-lg mb-2">Vous trouverez votre facture par mail.</p>
    <p class="text-lg m-0 flex items-center">Pour afficher votre espace location, cliquer <router-link to="/" class="ml-2"><b-button type="is-success">Ici</b-button></router-link></p>
  </div>
</template>
<script>
export default {
  name:"thanks",
  data: () => ({car: null}),
  created() {
    console.log(this.$route.params.check);
    localStorage.removeItem('rent');
  }
}
</script>