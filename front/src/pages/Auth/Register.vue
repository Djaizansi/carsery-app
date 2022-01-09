<template>
<form @submit.prevent="handleSubmit">
    <div class="modal-card xs:px-7">
      <header class="modal-card-head">
        <p class="modal-card-title">Inscrivez-vous</p>
        <button
            type="button"
            class="delete"
            @click="$emit('close')"
        />
      </header>
      <section class="modal-card-body">
        <div v-if="roles === 'ROLE_CLIENT'">
          <div class="flex space-x-3">
            <b-field
                label="Prénom"
                class="w-1/2"
                :type="errorData['firstname'] ? 'is-danger' : ''"
                :message="errorData['firstname'] ? errorData['firstname'] : ''"
            >
              <b-input
                  type="text"
                  name="firstname"
                  v-model="User.firstname"
                  min="3"
                  validation-message="Minimum 3 caractères"
                  placeholder="Votre prénom"
                  required>
              </b-input>
            </b-field>
            <b-field
                label="Nom"
                class="w-1/2"
                :type="errorData['lastname'] ? 'is-danger' : ''"
                :message="errorData['lastname'] ? errorData['lastname'] : ''"
            >
              <b-input
                  type="text"
                  name="lastname"
                  v-model="User.lastname"
                  min="2"
                  validation-message="Minimum 2 caractères"
                  placeholder="Votre nom"
                  required>
              </b-input>
            </b-field>
          </div>
          <div class="flex justify-center mt-6">
            <b-radio
                v-model="User.gender"
                name="gender"
                native-value="M"
                required
            >
              Masculin
            </b-radio>
            <b-radio v-model="User.gender"
                     name="gender"
                     native-value="F"
                     required
            >
              Féminin
            </b-radio>
          </div>
        </div>
        <b-field
            label="Email"
            :type="errorData['email'] ? 'is-danger' : ''"
            :message="errorData['email'] ? errorData['email'] : ''"
        >
          <b-input
              type="email"
              name="email"
              v-model="User.email"
              placeholder="Votre email"
              required>
          </b-input>
        </b-field>

        <b-field
            label="Mot de passe"
            :type="errorData.plainPassword ? 'is-danger' : ''"
            :message="errorData.plainPassword ? errorData.plainPassword : ''"
        >
          <b-input
              type="password"
              name="plainPassword"
              v-model="User.plainPassword"
              password-reveal
              placeholder="Votre mot de passe"
              required
          >
          </b-input>
        </b-field>

        <b-field label="Confirmez votre mot de passe">
          <b-input
              type="password"
              name="passwordConfirm"
              v-model="passwordConfirm"
              password-reveal
              placeholder="Confirmez votre mot de passe"
              required
          >
          </b-input>
        </b-field>
        <b-field label="Votre adresse">
          <vue-google-autocomplete
              id="map"
              classname="py-2 px-2 border rounded w-full text-center"
              placeholder="Votre adresse"
              v-on:placechanged="getAddressData"
              country="fr"
          >
          </vue-google-autocomplete>
        </b-field>
        <div class="flex justify-center mt-6">
            <b-radio
                v-model="roles"
                name="roles"
                native-value="ROLE_CLIENT"
                required
                >
                Client
            </b-radio>
            <b-radio v-model="roles"
                name="roles"
                native-value="ROLE_PRO"
                required
                >
                Professionnel
            </b-radio>
        </div>
        <p class="flex justify-center text-red-600 text-sm" :class="errorData['roles'] === [] ? '' : 'hidden'"><span class="mdi mdi-alert-outline"></span> {{errorData['roles'] !== [] ? errorData['roles'] : ''}}</p>
      </section>
      <footer class="modal-card-foot">
        <b-button v-if="!loading"
            label="S'inscrire"
            type="is-primary"
            native-type="submit"
            class="w-full"
        />
        <b-button v-else
            loading
            type="is-primary"
            class="w-full"
        />
      </footer>
    </div>
  </form>
</template>

<script>
import User from '../../Entity/User/User';
import ErrorUser from '../../Entity/User/ErrorUser';
import resetObject from '../../Utils/resetObject';
import VueGoogleAutocomplete from 'vue-google-autocomplete';

export default {
  components: {VueGoogleAutocomplete},
  data: () => ({User, passwordConfirm: "", roles: "", loading: false, errorData: {...ErrorUser}}),
  methods: {
    async handleSubmit() {
      this.loading = true;
      resetObject(this.errorData);
      if (User.plainPassword === this.passwordConfirm) {
        User.roles = [];
        User.roles.push(this.roles);
        if(User.roles.includes('ROLE_PRO')) {
          delete User.firstname;
          delete User.lastname;
          delete User.gender;
        }
        try {
          const res = await fetch("http://localhost:3000/users", {
            method: "POST",
            headers: {
              "Content-Type": "application/json"
            },
            body: JSON.stringify(User)
          });
          const data = await res.json();
          if (res.status === 422) {
            this.loading = false;
            data['violations'].forEach(err => this.errorData[err.propertyPath] = err.message);
          }else if(res.status === 201) {
            this.$emit('close');
            this.$buefy.toast.open({
              message: 'Inscription réussi. Vérifiez votre adresse mail en checkez vos mails',
              type: 'is-success'
            })
          }
        } catch (e) {
          console.log(e.response);
        }
      } else {
        this.loading = false;
        this.errorData['password'] = 'Les mots de passe ne correspondent pas. Veuillez réessayez';
      }
    },
    getAddressData: function (addressData) {
      User.address.city = addressData.locality;
      User.address.street = addressData.street_number + ' ' + addressData.route;
      User.address.country = addressData.country;
      User.address.postalCode = addressData.postal_code;
      User.address.region = addressData.administrative_area_level_1;
    }
  }
}
</script>

