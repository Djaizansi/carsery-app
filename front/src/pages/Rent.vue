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
      <div v-if="cars.length !== 0 && !cars.includes('')" class="flex flex-wrap justify-center gap-4">
        <div v-for="[key, value] of Object.entries(cars)" :key="key">
          <Card :car="value" :dates="dateFormat" type="rent"/>
        </div>
      </div>
      <div v-else-if="cars.includes('')">
        <p>Aucun résultat</p>
      </div>
    </div>
    <div v-else class="is-flex is-justify-content-center w-full" ref="element">
      <b-loading :is-full-page="false" v-model="loading" :can-cancel="false"></b-loading>
    </div>
  </div>
</template>

<script>
import dateFormat from '../Utils/dateFormat';
import Card from '../components/Card';
import axios from "axios";

export default {
  components: {Card},
  data: () => ({dates: [], cars: [], loading: false, message: "", unselectableDates: [new Date(Date.now() - 8640000)], dateFormat:[]}),
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
        this.dateFormat = this.dates.map(date => dateFormat(date,'en'));
        const [dateStart, dateEnd] = this.dateFormat;
        axios.get(`http://localhost:3000/getCarByDateBooking?startDate=${dateStart}&endDate=${dateEnd}`)
            .then(res => {
              this.loading = false;
              this.cars = res.data;
            });
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
