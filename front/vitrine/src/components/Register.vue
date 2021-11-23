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
        <div class="flex space-x-3" v-if="typeUser === 'client'">
          <b-field label="Prénom" class="w-1/2">
            <b-input
                type="text"
                name="firstname"
                placeholder="Votre prénom"
                required>
            </b-input>
          </b-field>
          <b-field label="Nom" class="w-1/2">
            <b-input
                type="text"
                name="lastname"
                placeholder="Votre nom"
                required>
            </b-input>
          </b-field>
        </div>
        <b-field label="Email">
          <b-input
              type="email"
              name="email"
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

        <b-field label="Confirmez votre mot de passe">
          <b-input
              type="password"
              name="passwordConfirm"
              password-reveal
              placeholder="Confirmez votre mot de passe"
              required
          >
          </b-input>
        </b-field>
        <div class="flex justify-center mt-6">
            <b-radio v-model="typeUser"
                name="typeUser"
                native-value="client"
                required
                >
                Client
            </b-radio>
            <b-radio v-model="typeUser"
                name="typeUser"
                native-value="pro"
                required
                >
                Professionnel
            </b-radio>
        </div>
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
export default {
  data: () => ({typeUser: "", loading: false}),
  methods: {
    async handleSubmit(event) {
        this.loading = true;
        const { firstname,lastname,email,password,passwordConfirm,typeUser } = Object.fromEntries(new FormData(event.target));
        if(password === passwordConfirm){
          const conditionRole = typeUser === 'client';
          const infoUser = { 
            email: email,
            password: password,
            roles: [
              conditionRole ? 'ROLE_USER' : 'ROLE_PROFESIONNAL'
            ]
          }
          const dataSend = conditionRole ? {
            firstname: firstname,
            lastname: lastname,
            ...infoUser
          } : infoUser;

          const response = await fetch("http://localhost:8095/users", {
            method: "POST",
            headers: {
              "Content-Type": "application/json"
            },
            body: JSON.stringify(dataSend)
          });
          const data = await response.json();
          if(data){
            if(data.code === 401){
              !this.loading;
            }else{
              !this.loading;
              //this.$router.push('/');
            }
          }
        }else{
          this.loading = false;
          console.log('Les mots de passe ne correspondent pas, veuillez réessayez');
        }
      }
    }
  }
</script>