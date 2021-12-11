<template>
  <div class="mt-5">
    <h1 class="flex justify-center text-xl font-bold mb-3">Réserver votre véhicule</h1>
    <form @submit.prevent="handleSubmit">
      <div class="is-flex is-flex-direction-column is-align-items-center mb-6">
        <b-datepicker
            placeholder="Choisissez une date de départ et date de retour"
            v-model="dates"
            locale="fr-FR"
            range
            :min-date="new Date()"
            class="w-96 text-center mb-2"
        >
        </b-datepicker>
        <b-button label="Valider" type="is-primary" native-type="submit"/>
      </div>
    </form>
    <div v-if="!loading" class="mb-10 p-5 flex justify-center flex-wrap">
      <div v-if="cars.length !== 0" class="flex flex-wrap justify-center gap-4">
        <div v-for="[key, value] of Object.entries(cars)" :key="key">
          <Card :car="value"/>
        </div>
      </div>
    </div>
    <div v-else class="is-flex is-justify-content-center w-full" ref="element">
      <b-loading :is-full-page="false" v-model="loading" :can-cancel="false"></b-loading>
    </div>
  </div>
</template>

<script>
import dateFormat from '../Utils/dateFormat';
import Card from './Card';

export default {
  components: {Card},
  data: () => ({dates: [], cars: [], loading: false, message: "",unselectableDates: [new Date(Date.now() - 8640000)]}),
  methods: {
    async handleSubmit() {
      if (this.dates.length === 0) {
        this.$buefy.notification.open({
          message: `Choisissez vos dates de départ et de retour`,
          duration: 4000,
          hasIcon: true,
          progressBar: true,
          type: 'is-danger',
        })
      } else {
        this.loading = true;
        const myDates = this.dates.map(date => dateFormat(date));
        // eslint-disable-next-line no-unused-vars
        const [dateStart, dateEnd] = myDates;
        setTimeout(() => {
          this.loading = false
          this.cars.push({
            brand: "Bmw",
            model: "Serie 1",
            category: "berline",
            power: "150",
            color: "blue",
            kilometer: "145 000",
            price: 150,
            date_registration: "15/12/2017"
          },{
            brand: "Bmw",
            model: "Serie 1",
            category: "berline",
            power: "150",
            color: "blue",
            kilometer: "145 000",
            price: 150,
            date_registration: "15/12/2017"
          },{
            brand: "Bmw",
            model: "Serie 1",
            category: "berline",
            power: "150",
            color: "blue",
            kilometer: "145 000",
            price: 150,
            date_registration: "15/12/2017"
          },{
            brand: "Bmw",
            model: "Serie 1",
            category: "berline",
            power: "150",
            color: "blue",
            kilometer: "145 000",
            price: 150,
            date_registration: "15/12/2017"
          });
        }, 10 * 300)
      }
    }
  }
}
</script>

<style>
.input:first-child {
  text-align: center;
}
</style>
