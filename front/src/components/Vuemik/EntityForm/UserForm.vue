<template>
  <div>
    <div v-show="error.length !== 0" class="p-5 bg-red-100 rounded mb-2">
      <p v-for="(myError,index) in error" :key="index">{{ myError }}</p>
    </div>
    <Vuemik
        :initialValues="{
      firstname: initialValues.firstname,
      lastname: initialValues.lastname,
      gender: initialValues.gender,
    }"
        :onSubmit="onSubmit"
        v-slot="{ handleSubmit }"
        class="flex flex-col justify-between space-y-2"
    >
      <Field name="firstname" component="input" class="border p-3" placeholder="Votre prénom" />
      <Field name="lastname" component="input" class="border p-3" placeholder="Votre nom" />
      <div class="flex items-center justify-center space-x-2">
        <label for="man">Homme</label>
        <Field name="gender" component="input" class="border p-3" type="radio" value="M" id="man"/>

        <label for="woman">Femme</label>
        <Field name="gender" component="input" class="border p-3" type="radio" value="F" id="woman"/>
      </div>
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
import {ToastProgrammatic as Toast} from 'buefy';

export default {
  name: "UserForm",
  components: {Vuemik,Field},
  data: () => ({error: [],loadingPut:false}),
  props: {
    initialValues: {type: Object, required: true},
    id: {type: Number}
  },
  methods: {
    onSubmit: function(event){
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