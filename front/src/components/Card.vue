<template>
  <div class="card w-80">
    <div class="card-image">
      <figure class="image is-4by3">
        <img src="https://via.placeholder.com/150x150" alt="placeholder-img">
      </figure>
    </div>
    <div class="card-content">
      <div class="mb-4 flex justify-between">
        <div>
          <p class="title is-4">{{ car.model }}</p>
          <p class="subtitle is-6">{{ car.brand }}</p>
        </div>
        <p class="font-bold text-xl">{{car.price}} €/j</p>
      </div>

      <div class="content grid gap-4 grid-cols-2 mb-5 flex is-align-items-center">
        <p class="m-0"><span class="mdi mdi-car-back"></span> {{ car.category }}</p>
        <p class="m-0"><span class="mdi mdi-car-shift-pattern"></span> {{ car.power }} ch</p>
        <span class="w-4 h-4 rounded-full" :style="{backgroundColor: car.color}"></span>
        <p class="m-0"><span class="mdi mdi-car-cog"></span> {{ car.kilometer }} km</p>
        <p class="m-0"><span class="mdi mdi-calendar-range"></span> {{ car.date_registration }}</p>
      </div>
      <b-button label="Réserver" type="is-primary" class="w-full"/>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    car: {
      type: Object,
      required: true
    },
  }
}
</script>

<style>

</style>
