<template>
  <form @submit.prevent="handleSubmit">
    <div class="modal-card xs:px-7">
      <header class="modal-card-head">
        <p class="modal-card-title">Modifier véhicule</p>
      </header>
      <section class="modal-card-body">
        <b-field
            label="Plaque d'immatriculation"
            label-position="on-border"
            :type="errorData.numberplate ? 'is-danger' : ''"
            :message="errorData.numberplate ? errorData.numberplate : ''"
        >
          <b-input
              type="text"
              name="numberplate"
              v-model="car.numberplate"
              placeholder="Plaque d'immatriculation de votre véhicule"
              required>
          </b-input>
        </b-field>
        <b-field
            label="Kilométrage"
            label-position="on-border"
            :type="errorData.kilometer ? 'is-danger' : ''"
            :message="errorData.kilometer ? errorData.kilometer : ''"
        >
          <b-numberinput name="kilometer" v-model="car.kilometer" required :min="3" placeholder="Kilométrage du véhicule"></b-numberinput>
        </b-field>

        <b-field
            label="Prix"
            label-position="on-border"
            :type="errorData.price ? 'is-danger' : ''"
            :message="errorData.price ? errorData.price : ''"
        >
          <b-numberinput name="price" v-model="car.price" required :min="10" placeholder="Prix de la location à la journée"></b-numberinput>
        </b-field>
        <div class="text-center">
          <b-radio v-model="car.status"
                   name="status"
                   :native-value=true>
            Disponible
          </b-radio>
          <b-radio v-model="car.status"
                   name="status"
                   :native-value=false>
            Indisponible
          </b-radio>
        </div>
      </section>

      <footer class="modal-card-foot">
        <b-button v-if="!loading"
                  label="Modifier"
                  type="is-primary"
                  native-type="submit"
                  class="w-full"
        />
        <b-button v-else
                  loading
                  type="is-primary"
                  class="w-full"
        />
      </footer>
    </div>
  </form>
</template>

<script>
import ErrorCar from '../Entity/Car/ErrorCar';
import Car from '../Entity/Car/Car';
import axios from "axios";

export default {
  name: "UpdateCar",
  data: () => ({loading: false,errorData: {...ErrorCar}}),
  props: {
    car: {
      type: Object
    }
  },
  methods: {
    handleSubmit(){
      Car.kilometer = this.car.kilometer;
      Car.price = this.car.price;
      Car.status = this.car.status;
      Car.numberplate = this.car.numberplate;
      Object.keys(Car).map(attr => {
        if(Car[attr] === null || attr === 'color'){
          delete Car[attr];
        }
      });
      axios.put('http://localhost:3000/cars/'+this.car.id,Car)
          .then(res => {
            if(res.status === 422){
              res.data['violations'].forEach(err => this.errorData[err.propertyPath] = err.message);
            }else if(res.status === 200){
              this.$emit('close');
              this.notification(`Véhicule enregistré avec succés.`,'is-success');
            }
          });
    },
    notification(message,type) {
      if(type === "is-success") this.loading = false;
      this.$buefy.toast.open({
        duration: 3000,
        message: message,
        type: type
      })
    },
  }
}
</script>
