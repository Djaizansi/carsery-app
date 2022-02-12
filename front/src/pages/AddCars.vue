<template>
  <div>
    <h1 class="text-center text-3xl font-bold mb-5">Ajouter un véhicule</h1>
    <div class="flex flex-col items-center mx-auto" style="width:500px;">
      <div class="w-full">
        <form @submit.prevent="handleSubmit">
          <b-field label="Catégorie" label-position="on-border">
            <b-select placeholder="Choisissez la catégorie de votre voiture" v-model="category" name="category" required expanded ref="categorie">
              <option selected disabled>Choisissez une catégorie</option>
            </b-select>
          </b-field>

          <b-field label="Marque" label-position="on-border">
            <b-select placeholder="Choisissez la marque de votre voiture" required expanded ref="brand" v-model.lazy="brand">
              <option selected disabled>Choisissez une marque</option>
            </b-select>
          </b-field>

          <b-field label="Modèle" label-position="on-border">
            <b-select placeholder="Choisissez le modèle de votre voiture" name="model" v-model.lazy="model" required expanded ref="model">
              <option selected disabled>Choisissez un modèle</option>
            </b-select>
          </b-field>

          <b-field
              label="Plaque d'immatriculation"
              label-position="on-border"
              :type="errorData.numberplate ? 'is-danger' : ''"
              :message="errorData.numberplate ? errorData.numberplate : ''"
          >
            <b-input
                type="text"
                name="numberplate"
                v-model="Car.numberplate"
                placeholder="Plaque d'immatriculation de votre véhicule"
                required>
            </b-input>
          </b-field>

          <b-field
              label="Date de première immatriculation"
              label-position="on-border"
              :type="errorData.dateRegistration ? 'is-danger' : ''"
              :message="errorData.dateRegistration ? errorData.dateRegistration : ''"
          >
            <b-datepicker
                placeholder="Choisissez une date"
                v-model="dateRegistration"
                name="dateRegistration"
                required
            >
            </b-datepicker>
          </b-field>

          <b-field
              label="Couleur du véhicule"
              label-position="on-border"
              :type="errorData.color ? 'is-danger' : ''"
              :message="errorData.color ? errorData.kilometer : ''"
          >
            <b-input
                type="color"
                name="color"
                v-model="Car.color"
                placeholder="Votre couleur"
                required>
            </b-input>
          </b-field>

          <b-field
              label="Kilométrage"
              label-position="on-border"
              :type="errorData.kilometer ? 'is-danger' : ''"
              :message="errorData.kilometer ? errorData.kilometer : ''"
          >
            <b-numberinput name="kilometer" v-model="Car.kilometer" required :min="3" placeholder="Kilométrage du véhicule"></b-numberinput>
          </b-field>

          <b-field
              label="Puissance (CH)"
              label-position="on-border"
              :type="errorData.power ? 'is-danger' : ''"
              :message="errorData.power ? errorData.power : ''"
          >
            <b-numberinput name="power" v-model="Car.power" required :max="1500" placeholder="Puissance du véhicule"></b-numberinput>
          </b-field>

          <b-field
              label="Prix"
              label-position="on-border"
              :type="errorData.price ? 'is-danger' : ''"
              :message="errorData.price ? errorData.price : ''"
          >
            <b-numberinput name="price" v-model="Car.price" required :min="10" placeholder="Prix de la location à la journée"></b-numberinput>
          </b-field>

          <b-field class="m-0">
            <b-upload v-model="dropFiles"
                      multiple
                      drag-drop
                      expanded
            >
              <section class="section">
                <div class="content has-text-centered">
                  <p>
                    <b-icon
                        icon="upload"
                        size="is-large">
                    </b-icon>
                  </p>
                  <p>Déposez les images de votre véhicule</p>
                </div>
              </section>
            </b-upload>
          </b-field>
          <div class="tags">
            <span v-for="(file, index) in dropFiles"
                  :key="index"
                  class="tag is-primary" >
                {{file.name}}
                <button class="delete is-small"
                        type="button"
                        @click="deleteDropFile(index)">
                </button>
            </span>
          </div>
          <b-button v-if="!loading" type="is-primary" class="mb-5 w-full" native-type="submit">Envoyer</b-button>
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
import {createOption,resetSelect} from "../Utils/selectField";
import Car from "../Entity/Car/Car";
import ErrorCar from "../Entity/Car/ErrorCar";
import dateFormat from "../Utils/dateFormat";

export default {
  name: "AddCars",
  data: () => ({
    Car,
    dropFiles: [],
    loading:false,
    brands: [],
    brand: null,
    dateRegistration: [],
    errorData: {...ErrorCar},
    image:[],
    model: null,
    category: null,
    path: ""
  }),
  watch: {
    brand: function(value){
      const selectModel = this.$refs.model.$el.querySelector('select');
      resetSelect(selectModel);
      this.brands.map(brand => {
        if(brand.id === parseInt(value)){
          createOption("",`${brand.name} (${brand.models.length})`,selectModel,true);
          brand.models.map(option => {
            createOption(option.id,option.name,selectModel);
          })
        }
      });
    }
  },
  mounted() {
    //Get all categories
    axios.get('http://localhost:3000/categories')
      .then(res => res.data)
      .then(data => {
        const selectCategory = this.$refs.categorie.$el.querySelector('select');
        data.map(option => {
          createOption(option.id,option.name,selectCategory);
        });
      })
      .catch(e => console.log(e));

    //Get all Brands
    axios.get('http://localhost:3000/brands')
        .then(res => res.data)
        .then(data => {
          this.brands = data;
          const selectBrand = this.$refs.brand.$el.querySelector('select');
          this.brands.map(option => {
            createOption(option.id,option.name,selectBrand);
          })
        })
        .catch(e => console.log(e));
  },
  methods: {
    deleteDropFile(index) {
      this.dropFiles.splice(index, 1)
    },
    handleSubmit(){
      Car.user = this.$store.state.user.id;
      Car.status = this.$store.state.user.roles.includes("ROLE_ADMIN") && true;
      Car.statusAdminCar = this.$store.state.user.roles.includes("ROLE_PRO") ? "waiting" : "admin";
      Car.dateRegistration = dateFormat(this.dateRegistration,"en");
      Car.model = `/models/${this.model}`;
      Car.category = `/categories/${this.category}`;
      Car.typeCarUser = this.$store.state.user.roles.includes("ROLE_PRO") ? 'pro': 'admin';
      this.upload(Car);
    },
    createBase64Image(filesObject) {
      if(filesObject.length > 0){
        filesObject.map(file => {
          const reader = new FileReader();
          reader.onload = (e) => {
            this.image = e.target.result;
            this.upload(null,this.image);
          }
          reader.readAsDataURL(file);
        });
      }
    },
    upload(obj=null,image=null){
      this.loading = true;
      axios.post('http://localhost:3000/addCar',image !== null ? {image: image, path: this.path} : obj)
          .then(res => {
            this.errorData = [];
            if(obj !== null){
              if(res.status === 422){
                res.data['violations'].forEach(err => this.errorData[err.propertyPath] = err.message);
              }else if(res.status === 201){
                if(this.dropFiles.length === 0) {
                  this.notification(
                      `Véhicule enregistré avec succés.`,'is-success')
                  this.resetAttribute();
                }
                this.path = `voiture/${res.data.id}`;
                this.createBase64Image(this.dropFiles);
              }
            }else if(image !== null) {
              this.notification(`Véhicule enregistré avec succés.`,'is-success');
              this.resetAttribute();
            }
          });
    },
    notification(message,type) {
      if(type === "is-success") this.loading = false;
      this.$buefy.toast.open({
        duration: 7000,
        message: message,
        type: type
      })
    },
    resetAttribute(){
      Object.keys(Car).map(car => {
        Car[car] = car === "color" ? "#000000" : null;
        this.brand = null;
        this.model = null;
        this.category = null;
        this.dateRegistration = [];
        this.dropFiles = [];
      })
    }
  }
}
</script>