<template>
  <div>
    <div v-if="loading" class="is-flex is-justify-content-center w-full" ref="element">
      <b-loading :is-full-page="true" v-model="loading" :can-cancel="false"></b-loading>
    </div>
    <div v-else-if="!loading" class="flex flex-col items-center">
      <h1 class="text-center text-3xl font-bold mb-5">Votre profil</h1>
      <b-tabs v-model="activeTab" type="is-toggle-rounded">
        <template v-for="tab in tabs">
          <b-tab-item
              v-if="tab.displayed"
              :key="tab.id"
              :value="tab.id"
              :icon="tab.icon"
              :label="tab.label">
            <component :is="tab.component" :initialValues="tab.content" :id="tab.idUpdate"></component>
          </b-tab-item>
        </template>
      </b-tabs>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import UserForm from "../components/Vuemik/EntityForm/UserForm";
import PasswordForm from "../components/Vuemik/EntityForm/PasswordForm";
import AddressForm from "../components/Vuemik/EntityForm/AddressForm";
import CompanyForm from "../components/Vuemik/EntityForm/CompanyForm";

export default {
  data: () => ({activeTab: null,roles:null,user:null,loading:null,id:null}),
  components: {UserForm,PasswordForm,AddressForm,CompanyForm},
  created() {
    this.roles = this.$store.state.user.roles;
    this.activeTab = this.roles.includes('ROLE_CLIENT') ? 'user' : 'company';
    this.loading = true;
  },
  mounted() {
    this.id = JSON.parse(this.$cookie.get('user_get')).id;
    setTimeout(() => {
      axios.get(`http://localhost:3000/users/${this.id}`)
          .then(res => res.data)
          .then(data => {
            this.loading = false;
            this.user = data;
          });
    },500);
  },
  computed: {
    baseTabs() {
      return [
        {
          id: 'user',
          label: 'Utilisateur',
          component: UserForm,
          idUpdate: this.id,
          content: {
            'firstname': this.user.firstname,
            'lastname': this.user.lastname,
            'gender': this.user.gender
          },
          icon: "account",
          displayed: this.roles.includes('ROLE_CLIENT'),
        },
        {
          id: 'company',
          label: 'Entreprise',
          idUpdate: this.id,
          component: CompanyForm,
          content: {
            "company": this.user.company,
            "siret": this.user.siret
          },
          icon: "domain",
          displayed: this.roles.includes('ROLE_PRO'),
        },
        {
          id: 'password',
          label: 'Mot de passe',
          idUpdate: this.id,
          component: PasswordForm,
          content: {},
          icon: "form-textbox-password",
          displayed: true,
        },
        {
          id: 'address',
          idUpdate: this.user.address.id,
          label: 'Adresse',
          component: AddressForm,
          content: {
            address: {
              "city":this.user.address.city,
              "country":this.user.address.country,
              "postalCode":this.user.address.postalCode,
              "region":this.user.address.region,
              "street":this.user.address.street,
            }
          },
          icon: "map-marker",
          displayed: true,
        }
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
