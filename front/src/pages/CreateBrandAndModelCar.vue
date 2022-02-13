<template>
  <div>
    <h1 class="text-center text-3xl font-bold mb-5">Ajouter un type de véhicule</h1>
    <div class="flex flex-col items-center mx-auto" style="width:500px;">
      <div class="w-full">
        <form @submit.prevent="handleSubmit">
          <b-field
              label="Marque"
              label-position="on-border"
              :type="errorData.brand ? 'is-danger' : ''"
              :message="errorData.brand ? errorData.brand : ''"
          >
            <b-input
                type="text"
                name="brand"
                v-model="Car.brand"
                placeholder="Marque du véhicule"
                required>
            </b-input>
          </b-field>

          <b-field
              label="Modèle du véhicule"
              label-position="on-border"
              :type="errorData.model ? 'is-danger' : ''"
              :message="errorData.model ? errorData.model : ''"
          >
            <b-input
                type="text"
                name="model"
                v-model="Car.model"
                placeholder="Le modèle du véhicule"
                required>
            </b-input>
          </b-field>
          <b-button v-if="!isLoading" type="is-primary" class="mb-5 w-full" native-type="submit">Envoyer</b-button>
          <b-button v-else
                    loading
                    type="is-primary"
                    class="w-full mb-5"
          />
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "CreateBrandAndModelCar",
  data: () => ({Car:{brand:null,model:null},errorData:{brand:null,model:null},isLoading: false}),
  methods: {
    handleSubmit(){
      this.isLoading = true;
      axios.post('http://localhost:3000/brands',{
        name: this.Car.brand.toUpperCase(),
        models: [{
          name: this.Car.model.toUpperCase()
        }]
      })
          .then(res => {
            this.isLoading = false;
            if(res.status === 201){
              this.$buefy.toast.open({
                duration: 3000,
                message: 'Type de véhicule ajouté !',
                type: 'is-success'
              })
              this.resetForm();
            }else if(res.status === 422){
              res.data['violations'].forEach(err => this.errorData[err.propertyPath] = err.message);
            }
          })
    },
    resetForm(){
      Object.keys(this.Car).map(car => {
        this.Car[car] = null
      });
    }
  }
}
</script>