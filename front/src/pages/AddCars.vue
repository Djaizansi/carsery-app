<template>
  <div>
    <h1 class="text-center text-3xl font-bold mb-5">Ajouter un véhicule</h1>
    <div class="flex flex-col items-center mx-auto" style="width:500px;">
      <div class="w-full">
        <form>
          <b-field label="Catégorie" label-position="on-border">
            <b-select placeholder="Choississez la catégorie de votre voiture" required expanded>
              <option value="1">Option 1</option>
              <option value="2">Option 2</option>
            </b-select>
          </b-field>

          <b-field label="Marque" label-position="on-border">
            <b-select placeholder="Choississez la marque de votre voiture" required expanded>
              <option value="1">Option 1</option>
              <option value="2">Option 2</option>
            </b-select>
          </b-field>

          <b-field label="Modèle" label-position="on-border">
            <b-select placeholder="Choississez le modèle de votre voiture" required expanded>
              <option value="1">Option 1</option>
              <option value="2">Option 2</option>
            </b-select>
          </b-field>

          <b-field
              label="Plaque d'immatriculation"
              label-position="on-border"
          >
            <b-input
                type="text"
                name="numberplate"
                placeholder="Plaque d'immatriculation de votre véhicule"
                required>
            </b-input>
          </b-field>

          <b-field
              label="Date de première immatriculation"
              label-position="on-border"
          >
            <b-datepicker
                placeholder="Choisissez une date">
            </b-datepicker>
          </b-field>

          <b-field
              label="Couleur du véhicule"
              label-position="on-border"
          >
            <b-input
                type="color"
                name="color"
                placeholder="Votre couleur"
                required>
            </b-input>
          </b-field>

          <b-field label="Kilométrage" label-position="on-border">
            <b-numberinput name="kilometer" required :min="3" placeholder="Kilométrage du véhicule"></b-numberinput>
          </b-field>

          <b-field label="Puissance (CH)" label-position="on-border">
            <b-numberinput name="power" required :min="3" placeholder="Puissance du véhicule"></b-numberinput>
          </b-field>

          <b-field label="Prix" label-position="on-border">
            <b-numberinput name="price" required :min="10" placeholder="Prix de la location à la journée"></b-numberinput>
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
          <b-button v-if="!loading" class="is-primary mb-5 w-full">Envoyer</b-button>
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
  name: "AddCars",
  data: () => ({dropFiles: [],loading:false}),
  mounted() {
    axios.get('http://localhost:3000/categories')
      .then(res => res.data)
      .then(data => console.log(data))
      .catch(e => console.log(e));
  },
  methods: {
    deleteDropFile(index) {
      this.dropFiles.splice(index, 1)
    }
  }
}
</script>