<template>
  <section class="hero is-medium is-link">
    <div class="hero-body">
      <p class="is-size-2">
        Le système de location de voiture repensé pour <vue-typer :text="string" :shuffle='true' class="has-text-white"></vue-typer>
      </p>
    </div>
  </section>
</template>

<script>
module.exports = {
  data: function() {
    return {
      string: ['les particuliers 👀', 'les professionnels 💯', 'les novices 🕺', 'les passionnés 😍']
    }
  }
}
</script>

<style>
.custom.char {
  color: aqua;

}
</style>