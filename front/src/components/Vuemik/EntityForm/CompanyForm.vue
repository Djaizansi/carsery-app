<template>
  <div>
    <div v-show="error.length !== 0" class="p-5 bg-red-100 rounded mb-2">
      <p v-for="(myError,index) in error" :key="index">{{ myError }}</p>
    </div>
    <Vuemik
        :initialValues="{
      company: initialValues.company,
      siret: initialValues.siret,
    }"
        :onSubmit="onSubmit"
        v-slot="{ handleSubmit }"
        class="flex flex-col justify-between space-y-2"
    >
      <Field name="company" component="input" class="border p-3" placeholder="Votre nom d'entreprise" />
      <Field name="siret" component="input" class="border p-3" placeholder="Votre numéro de siret" />
      <b-button v-if="!loadingPut" @click="handleSubmit" class="is-primary">Envoyer</b-button>
      <b-button v-else
                loading
                type="is-primary"
      />
    </Vuemik>
  </div>
</template>

<script>
import Vuemik from "../Vuemik";
import Field from "../Field";
import axios from "axios";
import {ToastProgrammatic as Toast} from "buefy";

export default {
  name: "CompanyForm",
  data: () => ({error:[],loadingPut:false}),
  components: {Vuemik,Field},
  props: {
    initialValues: {type: Object, required: true},
    id: {type: Number}
  },

  methods: {
    onSubmit: function(event) {
      this.loadingPut = true;
      axios.put(`http://localhost:3000/users/${this.id}`,event)
          .then(res => {
            this.loadingPut = false;
            this.error = [];
            if(res.status === 200){
              Toast.open({
                message: 'Modification réussi',
                type: 'is-success'
              })
            }else{
              Object.keys(res.data.violations).map(error => this.error.push(res.data.violations[error].message));
            }
          });
    }
  },
}
</script>

<style>

</style>