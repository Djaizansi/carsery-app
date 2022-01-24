<template>
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
    <Field name="oldPassword" component="input" class="border p-3" type="password" placeholder="Votre ancien mot de passe" />
    <Field name="newPassword" component="input" class="border p-3" type="password" placeholder="Votre nouveau mot de passe" />
    <Field name="confirmPassword" component="input" class="border p-3" type="password" placeholder="Confirmez votre nouveau mot de passe" />
    <b-button @click="handleSubmit" class="is-primary">Envoyer</b-button>
  </Vuemik>
</template>

<script>
import Vuemik from "../Vuemik";
import Field from "../Field";
export default {
  name: "PasswordForm",
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