<template>
  <div class="w-full">
    <form @submit.prevent="handleSubmit">
      <div class="border rounded p-5">
        <label>Numéro de carte</label>
        <div id="card-number" class="mb-2 border rounded p-3"></div>
        <div class="flex space-x-4">
          <div class="w-1/2">
            <label>Exp carte</label>
            <div id="card-expiry" class="mb-2 border rounded p-3"></div>
          </div>
          <div class="w-1/2">
            <label>CVC</label>
            <div id="card-cvc" class="mb-2 border rounded p-3"></div>
          </div>
        </div>
        <b-button v-if="!loading" native-type="submit" type="is-primary" class="w-full">Payer {{price}} €</b-button>
        <b-button v-else
                  loading
                  type="is-primary"
                  class="w-full mb-5"
        />
        <div class="text-red-500">{{error}}</div>
      </div>
    </form>
  </div>
</template>

<script>
import axios from "axios";

export default {
  props: {
    price: {
      type: Number,
      required: true
    }
  },
  data: () => ({cardNumber: null, cardExpiry: null, cardCvc: null,error: null,loading: false}),
  computed: {
    stripeElements() {
      return this.$stripe.elements();
    },
    stripe() {
      return this.$stripe;
    }
  },
  mounted() {
    const style = {
      base: {
        color: 'black',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
          color: '#aab7c4',
        },
      },
      invalid: {
        color: '#fa755a',
        iconColor: '#fa755a',
      },
    };
    this.cardNumber = this.stripeElements.create('cardNumber', {style});
    this.cardNumber.mount('#card-number');
    this.cardExpiry = this.stripeElements.create('cardExpiry', {style});
    this.cardExpiry.mount('#card-expiry');
    this.cardCvc = this.stripeElements.create('cardCvc', {style});
    this.cardCvc.mount('#card-cvc');
  },
  beforeDestroy() {
    this.cardNumber.destroy();
    this.cardExpiry.destroy();
    this.cardCvc.destroy();
  },
  methods: {
    async handleSubmit() {
      try {
        this.loading = true;
        const user = await axios.get('http://localhost:3000/users/' + this.$store.state.user.id);
        const response = await axios.post("http://localhost:3000/stripe/intent", JSON.stringify({price: this.price}));
        const secret = await response.data;
        const getInfoUser = await user.data;
        const billingDetails = {
          name: getInfoUser.roles.includes('ROLE_PRO') ? getInfoUser.company : getInfoUser.firstname + ' ' + getInfoUser.lastname,
          email: getInfoUser.email,
          address: {
            city: getInfoUser.address.city,
            line1: getInfoUser.address.street,
            state: getInfoUser.address.country,
            postal_code: getInfoUser.address.postalCode
          }
        };
        const paymentMethodReq = await this.paymentMethodReq(billingDetails);
        await this.confirmPayment(paymentMethodReq, secret);

        //router.push("/success");
      } catch (error) {
        console.log("error", error);
      }
    },

    async paymentMethodReq(billingDetails) {
      const paymentMethodReq = await this.stripe.createPaymentMethod({
        type: "card",
        card: this.cardNumber,
        billing_details: billingDetails
      });

      if (paymentMethodReq.error) {
        this.loading = false;
        this.error = paymentMethodReq.error.message;
        return 0;
      }

      return paymentMethodReq;
    },

    async confirmPayment(paymentMethodReq, secret) {
      const responseConfirmPayment = await this.stripe.confirmCardPayment(secret, {
        payment_method: paymentMethodReq.paymentMethod.id
      });

      if (responseConfirmPayment.error) {
        this.loading = false;
        this.error = responseConfirmPayment.error.message;
        return 0;
      } else if (responseConfirmPayment.paymentIntent) {
        await this.paymentSuccess(responseConfirmPayment.paymentIntent,paymentMethodReq);
      }
    },

    async paymentSuccess(paymentIntent,paymentMethod) {
      const rent = JSON.parse(localStorage.getItem('rent'));
      const addPaymentRent = await axios.post("http://localhost:3000/addPaymentRent", {
        rent: rent,
        user: this.$store.state.user,
        paymentIntent: paymentIntent,
        paymentMethod: paymentMethod.paymentMethod
      });
      if (addPaymentRent) {
        this.loading = false;
        await this.$router.push({name: 'thanks', params: {check: true}});
      }
    }
  }
};
</script>