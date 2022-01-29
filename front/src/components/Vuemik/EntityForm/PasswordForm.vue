<template>
  <div>
    <div v-show="error.length !== 0" class="p-5 bg-red-100 rounded mb-2">
      <p v-for="(myError,index) in error" :key="index">{{ myError }}</p>
    </div>
    <Vuemik
        :initialValues="{
      oldPassword: initialValues.old,
      newPassword: initialValues.new,
      confirmPassword: initialValues.confirm,
    }"
        :onSubmit="onSubmit"
        v-slot="{ handleSubmit }"
        class="flex flex-col justify-between space-y-2"
    >
      <Field name="oldPassword" component="input" class="border p-3" type="password" ref="oldPassword"
             placeholder="Votre ancien mot de passe"/>
      <Field name="newPassword" component="input" class="border p-3" type="password" ref="newPassword"
             placeholder="Votre nouveau mot de passe"/>
      <Field name="confirmPassword" component="input" class="border p-3" type="password" ref="confirmPassword"
             placeholder="Confirmez votre nouveau mot de passe"/>
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
  name: "PasswordForm",
  components: {Vuemik, Field},
  data: () => ({error: [],loadingPut:false}),
  props: {
    initialValues: {type: Object, required: true},
    id: {type: Number}
  },
  methods: {
    onSubmit: function (event) {
      this.loadingPut = true;
      this.error = [];
      const mdp = {
        "oldPassword": {
          "value": event.oldPassword,
          "error": "Veuillez rentrez votre ancien mot de passe"
        },
        "newPassword": {
          "value": event.newPassword,
          "error": "Veuillez rentrez votre nouveau mot de passe"
        },
        "confirmPassword": {
          "value": event.confirmPassword,
          "error": "Veuillez confirmez votre nouveau mot de passe"
        }
      };
      const refAllInput = [this.$refs["oldPassword"],this.$refs["newPassword"],this.$refs["confirmPassword"]];
      Object.keys(event).map(newMdp => {
        if (event[newMdp] === "" || event[newMdp] === undefined) {
          this.loadingPut = false;
          this.error.push(mdp[newMdp].error);
        }
      });
      if(this.error.length === 0 && event.newPassword !== event.confirmPassword){
        this.loadingPut = false;
        this.error.push("Les mots de passe ne sont pas identique");
      }

      if(this.error.length === 0) {
        const dataToSend = {
          "oldPassword":event.oldPassword,
          "plainPassword":event.newPassword
        };
        axios.put(`http://localhost:3000/users/${this.id}`,dataToSend)
            .then(res => {
              this.loadingPut = false;
              this.error = [];
              if(res.status === 200){
                refAllInput.map(ref => {
                  ref.$el.value = "";
                });
                Object.keys(event).map(elem => event[elem] = "");
                Toast.open({
                  message: 'Modification réussi',
                  type: 'is-success'
                })
              }else if(res.status === 401){
                this.error.push("L'ancien mot de passe n'est pas bon");
              }else if(res.status === 422){
                Object.keys(res.data.violations).map(error => this.error.push(res.data.violations[error].message));
              }
            });
      }
    }
  },
}
</script>

<style>

</style>