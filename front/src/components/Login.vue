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
        <p class="flex justify-center text-red-600 text-sm" :class="message === '' && 'hidden'"><span class="mdi mdi-alert-outline"></span> {{message}}</p>
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
  export default {
    data: () => ({rememberme: false, loading: false, message: ""}),
    methods: {
      async handleSubmit(event) {
        this.loading = true;
        const { email,password,rememberme } = Object.fromEntries(new FormData(event.target));
        const res = await fetch("http://localhost:3000/users/login", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({ email: email, password: password })
        });
        const data = await res.json();
        if(data){
          if(res.status === 401){
            this.loading = !this.loading;
            this.message = "L'email et/ou le mot de passe est incorrect";
          }else{
            const typeStorage = {session: sessionStorage, local: localStorage}
            rememberme !== 'undefined' && rememberme === 'check' ? typeStorage.local.setItem('user',data.token) : typeStorage.session.setItem('user',data.token);
            this.loading = !this.loading;
            this.$emit('close');
            this.$buefy.toast.open({
              message: 'Connecté',
              type: 'is-success'
            })
            //this.$router.push('/');
          }
        }
      }
    }
  }
</script>
