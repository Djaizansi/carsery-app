<template>
  <section class="hero is-medium is-link">
    <div class="hero-body">
      <p class="title">
        Le système de location de voiture repensé pour <vue-typer :text="string"></vue-typer>
      </p>
      <p class="subtitle">
        lorem
      </p>
    </div>
  </section>
</template>

<script>
module.exports = {
  data: function() {
    return {
      string: ['les particuliers', 'les professionnels', 'les novices', 'les passionnés']
    }
  }
}
</script>