<template>
    <div>
        <!-- TODO : Modifier le style et mettre un state loading pour modifier certains changement de texte et/ou d'affichage -->
        <form @submit.prevent="handleSubmit">
            <div class="flex flex-col w-1/2 mx-auto">
                <input class="" placeholder="Jallali" type="text" name="name"/>
                <input placeholder="youcef.jallali@gmail.com" type="email" name="email"/>
                <input placeholder="10 rue de paris" type="text" name="address"/>
                <input placeholder="Montreuil" type="text" name="city"/>
                <input placeholder="France" type="text" name="state"/>
                <input placeholder="93100" type="text" name="zip"/>
            </div>

            <br>

            <label>Numéro de carte</label>
            <div id="card-number"></div>
            <label>Expiration de carte</label>
            <div id="card-expiry"></div>
            <label>CVC</label>
            <div id="card-cvc"></div>
            <div id="card-error"></div>
            <button type="submit" id="custom-button" >Payer</button>
        </form>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                cardNumber: null,
                cardExpiry: null,
                cardCvc: null,
            };
        },
        computed: {
            stripeElements () {
                return this.$stripe.elements();
            },

            stripe () {
                return this.$stripe;
            }
        },
        mounted () {
            const style = {
                base: {
                    color: 'black',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '14px',
                    '::placeholder': {
                    color: '#aab7c4',
                    },
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a',
                },
            };
            this.cardNumber = this.stripeElements.create('cardNumber', { style });
            this.cardNumber.mount('#card-number');
            this.cardExpiry = this.stripeElements.create('cardExpiry', { style });
            this.cardExpiry.mount('#card-expiry');
            this.cardCvc = this.stripeElements.create('cardCvc', { style });
            this.cardCvc.mount('#card-cvc');
        },
        beforeDestroy () {
            this.cardNumber.destroy();
            this.cardExpiry.destroy();
            this.cardCvc.destroy();
        },
        methods: {
            async handleSubmit(event) {
                //TODO : Essayer de voir si on peut pas récupèrer les informations de l'utilisateur directement au lieu de les rentrer. A VOIR
                const { name, email, address, city, state, zip } = Object.fromEntries(
                    new FormData(event.target)
                );
                const billingDetails = {
                    name,
                    email,
                    address: {
                        city,
                        line1: address,
                        state,
                        postal_code: zip
                    }
                };
                console.log(billingDetails);
                try {
                    const response = await fetch("http://localhost:8110/stripe/intent", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ price: 20 })
                    });

                    const secret = await response.json();
                    const paymentMethodReq = await this.stripe.createPaymentMethod({
                        type: "card",
                        card: this.cardNumber,
                        billing_details: billingDetails
                    });
                    console.log("error?", paymentMethodReq);
                    
                    const { error } = await this.stripe.confirmCardPayment(secret, {
                        payment_method: paymentMethodReq.paymentMethod.id
                    });

                    console.log("error?", error);
                    //router.push("/success");
                } catch (error) {
                    console.log("error", error);
                }
            }
        }
    };
</script>

<style scoped>
    /* TODO : Mettre en place avec tailwindcss et supprimer ca */
    #custom-button {
        height: 30px;
        outline: 1px solid grey;
        background-color: green;
        padding: 5px;
        color: white;
    }

    #card-error {
        color: red;
    }
</style>