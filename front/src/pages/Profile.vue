<template>
  <div class="flex flex-col items-center">
    <h1 class="text-center text-3xl font-bold mb-5">Votre profil</h1>
    <b-tabs v-model="activeTab" type="is-toggle-rounded">
      <template v-for="tab in tabs">
        <b-tab-item
            v-if="tab.displayed"
            :key="tab.id"
            :value="tab.id"
            :icon="tab.icon"
            :label="tab.label">
          {{ tab.content }}
        </b-tab-item>
      </template>
    </b-tabs>
    <Vuemik
        :initialValues="{
      select: 2,
      checkbox: true,
      textarea: 'coucou',
      text: 'text',
      number: 123,
      password: 'test',
    }"
        :onSubmit="onSubmit"
        v-slot="{ handleSubmit }"
        class="flex flex-col justify-between"
    >
      <Field name="select" component="select" class="border p-3">
        <option value="1">Choice 1</option>
        <option value="2">Choice 2</option>
      </Field>
      <Field name="textarea" component="textarea" class="border p-3" />
      <div class="">
        <label>True or False ?</label>
        <Field name="checkbox" component="input" type="checkbox" />
      </div>
      <Field name="text" component="input" class="border p-3" placeholder="votre text ici" />
      <Field name="number" component="input" class="border p-3" type="number"/>
      <Field name="password" component="input" class="border p-3" type="password" />
      <b-button @click="handleSubmit">Envoyer</b-button>
    </Vuemik>
  </div>
</template>

<script>
import axios from "axios";
import Vuemik from "../components/Vuemik/Vuemik";
import Field from "../components/Vuemik/Field";

export default {
  components: {Vuemik,Field},
  data: () => ({activeTab: 'pictures',roles:null}),
  created() {
    this.roles = this.$store.state.user.roles;
  },
  mounted() {
    const id = JSON.parse(this.$cookie.get('user_get')).id;
    axios.get(`http://localhost:3000/users/${id}`);
  },
  methods: {
    onSubmit: (event) => {
      console.log(event);
    }
  },
  computed: {
    baseTabs() {
      return [
        {
          id: 'user',
          label: 'Utilisateur',
          content: 'FormBuilder User',
          icon: "account",
          displayed: this.roles.includes('ROLE_CLIENT'),
        },
        {
          id: 'password',
          label: 'Mot de passe',
          content: 'FormBuilder Password',
          icon: "form-textbox-password",
          displayed: true,
        },
        {
          id: 'address',
          label: 'Adresse',
          content: 'FormBuilder Address',
          icon: "map-marker",
          displayed: true,
        },
        {
          id: 'company',
          label: 'Entreprise',
          content: 'FormBuilder Company',
          icon: "domain",
          displayed: this.roles.includes('ROLE_PRO'),
        },
      ]
    },
    tabs() {
      return [...this.baseTabs]
    }
  }
}
</script>

<style>

</style>
