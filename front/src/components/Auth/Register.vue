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
        <div class="flex space-x-3" v-if="roles === 'ROLE_CLIENT'">
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
            :type="errorData.password ? 'is-danger' : ''"
            :message="errorData.password ? errorData.password : ''"
        >
          <b-input
              type="password"
              name="password"
              v-model="User.password"
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
export default {
  data: () => ({User, passwordConfirm: "", roles: "", loading: false, errorData: {...ErrorUser}}),
  methods: {
    async handleSubmit() {
      this.loading = true;
      resetObject(this.errorData);
      if (User.password === this.passwordConfirm) {
        User.roles = [];
        User.roles.push(this.roles);
        if(User.roles.includes('ROLE_PRO')) {
          delete User.firstname;
          delete User.lastname;
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
    }
  }
}
</script>

