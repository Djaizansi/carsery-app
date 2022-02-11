<template>
  <div class="card w-80">
    <div class="card-image">
      <b-carousel>
        <b-carousel-item v-for="(image, i) in car.images" :key="i">
          <b-image :src="image" alt="car" ratio="6by4"></b-image>
        </b-carousel-item>
      </b-carousel>
    </div>
    <div class="card-content">
      <div class="mb-2 flex justify-between">
        <div>
          <p class="title is-4">{{ car.model.name }}</p>
          <p class="subtitle is-6">{{ car.model.brand.name }}</p>
        </div>
        <p class="font-bold text-xl">{{car.price}} €/j</p>
      </div>
      <b-tag :type="car.typeCarUser === 'pro' ? 'is-info' : 'is-primary'">{{car.typeCarUser === "pro" ? 'Professionnel' : 'Carsery'}}</b-tag>

      <div class="mt-4 content grid gap-4 grid-cols-2 mb-5 flex is-align-items-center">
        <p class="m-0"><span class="mdi mdi-card-bulleted"></span> {{ car.numberplate }}</p>
        <p class="m-0 flex space-x-1"><span class="mdi mdi-palette"></span><b-tag class="w-1/2" :style="{backgroundColor: car.color}"></b-tag></p>
        <p class="m-0"><span class="mdi mdi-car-back"></span> {{ car.category.name }}</p>
        <p class="m-0"><span class="mdi mdi-car-shift-pattern"></span> {{ car.power }} CH</p>
        <p class="m-0"><span class="mdi mdi-car-cog"></span> {{ car.kilometer }} km</p>
        <p class="m-0"><span class="mdi mdi-calendar-range"></span> {{ new Date(car.date_registration).toLocaleDateString() }}</p>
      </div>
      <b-button label="Réserver" @click="rentThisCar" type="is-primary" class="w-full"/>
    </div>
  </div>
</template>

<script>
import Login from "../pages/Auth/Login";

export default {
  props: {
    car: {
      type: Object,
      required: true
    },
  },
  methods: {
    rentThisCar(){
      if(this.$store.state.user !== ""){
        console.log(this.car);
      }else{
        this.cardModalLogin();
      }
    },
    cardModalLogin() {
      this.$buefy.modal.open({
        parent: this,
        component: Login,
        hasModalCard: true,
        customClass: 'custom-class custom-class-2',
        trapFocus: true
      })
    },
  }

}
</script>

<style>

</style>
