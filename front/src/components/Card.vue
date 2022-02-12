<template>
  <div :class="size ? 'w-'+size : 'w-80'" class="card">
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
        <p class="m-0 flex justify-end space-x-1"><span class="mdi mdi-palette"></span><b-tag class="w-1/2" :style="{backgroundColor: car.color}"></b-tag></p>
        <p class="m-0"><span class="mdi mdi-car-back"></span> {{ car.category.name }}</p>
        <p class="m-0 flex justify-end"><span class="mdi mdi-car-shift-pattern"></span> {{ car.power }} CH</p>
        <p class="m-0"><span class="mdi mdi-car-cog"></span> {{ car.kilometer }} km</p>
        <p class="m-0 flex justify-end space-x-2"><span class="mdi mdi-calendar-range"></span> <b-tag type="is-success">{{ new Date(car.date_registration).toLocaleDateString() }}</b-tag></p>
      </div>
      <b-button v-if="type === 'rent'" label="Réserver" @click="rentThisCar" type="is-primary" class="w-full"/>
      <div v-else-if="type === 'payment'" class="flex flex-col items-center">
        <p> Pour <b>{{numberDays}} {{numberDays > 1 ? 'jours' : 'journée'}}</b></p>
        <p> Du <b>{{new Date(dates[0]).toLocaleString().split(',')[0]}}</b> au <b>{{new Date(dates[1]).toLocaleString().split(',')[0]}}</b></p>
        <p class="font-bold text-lg mb-4"> Total : {{numberDays * car.price}} €</p>
        <Stripe :price="numberDays * car.price"/>
      </div>
      <div v-else>
      </div>
    </div>
  </div>
</template>

<script>
import Login from "../pages/Auth/Login";
import getNumberDate from "../Utils/getNumberDate";
import Stripe from '../components/Stripe.vue';

export default {
  props: {
    car: {
      type: Object,
      required: true
    },
    dates: {
      type: Array,
      required: true
    },
    type: {
      type: String
    },
    size: {
      type: String
    }
  },
  data: () => ({numberDays: 0}),
  components : {Stripe},
  mounted() {
    const [startDate,endDate] = this.dates;
    this.numberDays = getNumberDate(startDate,endDate);
  },
  methods: {
    rentThisCar(){
      if(this.$store.state.user !== ""){
        this.confirm();
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
    confirm() {
      this.$buefy.dialog.confirm({
        title: `${this.car.model.brand.name + ' ' + this.car.model.name} `,
        cancelText: 'Annuler',
        confirmText: 'Réserver',
        type: 'is-success',
        message: `Voulez-vous vraiment reserver ce véhicule
            <b>${this.numberDays} ${this.numberDays > 1 ? 'jours' : 'journée'}</b>
            pour <b>${this.car.price * this.numberDays} €</b> ?`,
        onConfirm: () => {
          localStorage.setItem('rent',JSON.stringify(this.transformObjectCar()));
          this.$router.push({name:'payment'});
        },
      })
    },
    transformObjectCar(){
      return {...this.car, chooseDate: this.dates}
    }
  }

}
</script>

<style>

</style>
