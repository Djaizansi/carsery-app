<template>
  <form @submit.prevent="handleSubmit">
    <div class="modal-card xs:px-7">
      <header class="modal-card-head">
        <p class="modal-card-title">Connectez-vous</p>
        <button
            type="button"
            class="delete"
            @click="$emit('close')"
        />
      </header>
      <section class="modal-card-body">
        <p class="flex justify-center text-red-600 text-sm" :class="message === '' && 'hidden'"><span
            class="mdi mdi-alert-outline"></span> {{ message }}</p>
        <b-field label="Email">
          <b-input
              type="email"
              name="email"
              message="coucou"
              placeholder="Votre email"
              required>
          </b-input>
        </b-field>

        <b-field label="Mot de passe">
          <b-input
              type="password"
              name="password"
              password-reveal
              placeholder="Votre mot de passe"
              required
          >
          </b-input>
        </b-field>

        <b-checkbox native-value="check" name="rememberme">Se souvenir de moi</b-checkbox>
      </section>
      <footer class="modal-card-foot">
        <b-button v-if="!loading"
                  label="Connexion"
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
import axios from 'axios';

export default {
  data: () => ({rememberme: false, loading: false, message: ""}),
  methods: {
    showErrorMessage(message){
      this.loading = !this.loading;
      this.message = message;
    },
    handleSubmit(event) {
      this.loading = true;
      const {email, password} = Object.fromEntries(new FormData(event.target));
      axios.post("http://localhost:3000/login", {email, password})
          .then(res => {
            if (res.status === 401) {
              this.showErrorMessage("L'email et/ou le mot de passe est incorrect");
            } else if (res.status === 403) {
              this.showErrorMessage("Votre compte n'est pas valide");
            }else {
              this.loading = !this.loading;
              this.$emit('close');
              this.$cookies.set('token', res.data.token);
              this.$cookies.set('refresh_token', res.data.refresh_token);
              this.$cookies.set('user_get', atob(res.data.token.split('.')[1]));
              this.$store.commit('SET_USER', this.$cookies.get('user_get'));
              this.$buefy.toast.open({
                message: 'Connecté',
                type: 'is-success'
              })
            }
          })
          .catch(e => console.log(e));
      //this.$router.push('/');
    }
  }
}
</script>
