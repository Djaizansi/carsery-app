<template>
  <Vuemik
      :initialValues="{
      address: initialValues.address
    }"
      :onSubmit="onSubmit"
      v-slot="{ handleSubmit }"
      class="flex flex-col justify-between space-y-2"
  >
    <vue-google-autocomplete
        id="map"
        classname="py-2 px-2 border rounded w-full text-center"
        placeholder="Votre adresse"
        v-on:placechanged="getAddressData"
        country="fr"
        :value="Object.keys(address).length !== 0 ? address.street+', '+address.city+', '+address.country : ''"
    >
    </vue-google-autocomplete>
    <b-button @click="handleSubmit" class="is-primary">Envoyer</b-button>
  </Vuemik>
</template>

<script>
import Vuemik from "../Vuemik";
import VueGoogleAutocomplete from "vue-google-autocomplete";

export default {
  name: "AddressForm",
  components: {Vuemik, VueGoogleAutocomplete},
  mounted() {
    this.address = this.initialValues.address;
  },
  data: () => ({address:{}}),
  props: {
    initialValues: {type: Object, required: true}
  },

  methods: {
    onSubmit: (event) => {
      console.log(event.address);
    },
    getAddressData(addressData) {
      this.address.city = addressData.locality;
      this.address.street = addressData.street_number + ' ' + addressData.route;
      this.address.country = addressData.country;
      this.address.postalCode = addressData.postal_code;
      this.address.region = addressData.administrative_area_level_1;
    }
  },
}
</script>

<style>

</style>