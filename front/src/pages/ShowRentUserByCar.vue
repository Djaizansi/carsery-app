<template>
  <div class="w-full">
    <div v-if="isLoading" class="is-flex is-justify-content-center w-full" ref="element">
      <b-loading :is-full-page="true" v-model="isLoading" :can-cancel="false"></b-loading>
    </div>
    <div v-else>
      <b-breadcrumb
          size="is-small"
          align="is-left"
          class="px-5"
      >
        <b-breadcrumb-item tag='router-link' to="/mes-locations">Mes locations</b-breadcrumb-item>
        <b-breadcrumb-item tag='router-link' :to="allInfo.booking ? `/mes-location/${allInfo.booking.id}` : ''" active>{{allInfo.car.model.brand.name + ' ' + allInfo.car.model.name}}</b-breadcrumb-item>
      </b-breadcrumb>
      <div class="w-full flex items-center justify-center px-5 space-x-5 mb-5">
        <Card :car="allInfo.car" :dates="[allInfo.booking.startDate,allInfo.booking.endDate]" size="1/2"/>
        <div class="flex flex-col w-1/2">
          <div class="border rounded drop-shadow-xl p-3 w-full mb-3">
            <p class="font-bold text-lg">Détail de la commande : #{{allInfo.order.num}}</p>
            <div class="mt-4">
              <p>Date de réservation : {{new Date(allInfo.booking.startDate).toLocaleString().split(',')[0]}} au {{new Date(allInfo.booking.endDate).toLocaleString().split(',')[0]}} </p>
              <p>Prix total payé : {{allInfo.order.amount}} €</p>
            </div>
          </div>
          <div class="border rounded drop-shadow-xl p-3 w-full mb-3">
            <p class="font-bold text-lg">Information facturation</p>
            <div class="mt-4 text-justify">
              <p>Client : {{ allInfo.stripe.billing_details.name}}</p>
              <p>Email : {{ allInfo.stripe.billing_details.email}}</p>
              <p>Adresse : {{ allInfo.stripe.billing_details.address.line1 }}</p>
              <p>Ville : {{ allInfo.stripe.billing_details.address.city }}</p>
              <p>Code postal : {{ allInfo.stripe.billing_details.address.postal_code }}</p>
              <p>Pays : {{ allInfo.stripe.billing_details.address.state }}</p>
            </div>
          </div>
          <div class="border rounded drop-shadow-xl p-3 w-full">
            <p class="font-bold text-lg">Méthode de paiement</p>
            <div>
              <div class="flex items-center space-x-2">
                <p>Carte utilisé :</p>
                <img class="m-0" alt="card-img" :src="allInfo.stripe.card.brand ? `https://img.icons8.com/color/48/000000/${allInfo.stripe.card.brand}.png` : ''"/>
                <p>**** **** **** {{allInfo.stripe.card.last4}}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import Card from "../components/Card";

export default {
  name:"ShowRentUserByCar",
  components: {Card},
  data: () => ({allInfo:null,isLoading:false}),
  created() {
    this.isLoading = true;
    axios.get('http://localhost:3000/getAllInfoOfBooking/'+this.$route.params.id)
        .then(res => {
          this.allInfo = res.data;
          this.allInfo.car.price = this.allInfo.booking.price;
          this.allInfo.car.kilometer = this.allInfo.booking.kilometer;
          this.isLoading = false;
        });
  }
}
</script>