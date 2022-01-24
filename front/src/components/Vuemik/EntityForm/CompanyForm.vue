<template>
  <Vuemik
      :initialValues="{
      company: initialValues.company,
      siret: initialValues.siret,
    }"
      :onSubmit="onSubmit"
      v-slot="{ handleSubmit }"
      class="flex flex-col justify-between space-y-2"
  >
    <Field name="company" component="input" class="border p-3" placeholder="Votre numéro de siret" />
    <Field name="siret" component="input" class="border p-3" placeholder="Votre nom d'entreprise" />
    <b-button @click="handleSubmit" class="is-primary">Envoyer</b-button>
  </Vuemik>
</template>

<script>
import Vuemik from "../Vuemik";
import Field from "../Field";
export default {
  name: "CompanyForm",
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