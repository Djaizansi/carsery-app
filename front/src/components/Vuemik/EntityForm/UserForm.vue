<template>
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
    <b-button @click="handleSubmit" class="is-primary">Envoyer</b-button>
  </Vuemik>
</template>

<script>
import Vuemik from "../Vuemik";
import Field from "../Field";
export default {
  name: "UserForm",
  components: {Vuemik,Field},
  props: {
    initialValues: {type: Object, required: true}
  },

  methods: {
    onSubmit: (event) => {
      console.log(event);
    }
  },
}
</script>

<style>

</style>