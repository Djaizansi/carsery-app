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
        <div class="flex space-x-3" v-if="typeUser === 'client'">
          <b-field label="Prénom" class="w-1/2">
            <b-input
                type="text"
                name="firstname"
                min="3"
                validation-message="Minimum 3 caractères"
                placeholder="Votre prénom"
                required>
            </b-input>
          </b-field>
          <b-field label="Nom" class="w-1/2">
            <b-input
                type="text"
                name="lastname"
                min="2"
                validation-message="Minimum 2 caractères"
                placeholder="Votre nom"
                required>
            </b-input>
          </b-field>
        </div>
        <b-field
            label="Email"
            :type="message !== '' && targetMessage === 'email' ? 'is-danger' : ''"
            :message="message !== '' && targetMessage === 'email' ? message : ''"
        >
          <b-input
              type="email"
              name="email"
              placeholder="Votre email"
              required>
          </b-input>
        </b-field>

        <b-field
            label="Mot de passe"
            :type="message !== '' && targetMessage === 'pwd' ? 'is-danger' : ''"
            :message="message !== '' && targetMessage === 'pwd'? message : ''"
        >
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
            <b-radio
                v-model="typeUser"
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
        <p class="flex justify-center text-red-600 text-sm" :class="targetMessage === 'roles' ? '' : 'hidden'"><span class="mdi mdi-alert-outline"></span> {{targetMessage === 'roles' && message}}</p>
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
  data: () => ({typeUser: "", loading: false, message:"", targetMessage:""}),
  methods: {
    async handleSubmit(event) {
        this.loading = true;
        const { firstname,lastname,email,password,passwordConfirm,typeUser } = Object.fromEntries(new FormData(event.target));
        if(password === passwordConfirm){
          const conditionRole = typeUser === 'client';
          const infoUser = {
            email: email.toLowerCase(),
            password: password,
            roles: [
              conditionRole ? 'ROLE_CLIENT' : 'ROLE_PROFESIONNAL'
            ]
          }
          const dataSend = conditionRole ? {
            firstname: firstname,
            lastname: lastname,
            ...infoUser
          } : infoUser;

          const res = await fetch("http://localhost:8095/users", {
            method: "POST",
            headers: {
              "Content-Type": "application/json"
            },
            body: JSON.stringify(dataSend)
          });
          const data = await res.json();
          const code = res.status;
          if(data){
            if(code === 401){
              !this.loading;
            }else if(code === 422){
              const error = data['violations'][0];
              this.loading = !this.loading;
              if(error.propertyPath === "email"){
                this.message = data['violations'][0].message;
                this.targetMessage = "email"
              }else if(error.propertyPath === "roles"){
                this.message = data['violations'][0].message;
                this.targetMessage = "roles"
              }else if(error.propertyPath === "password"){
                this.message = `
                  Votre mot de passe doit contenir : \n\n
                      - Minimum 8 caractères \n
                      - Au moins 1 chifffre \n
                      - Au moins un caractère majuscule et minuscule
                `;
                this.targetMessage = "pwd"
              }
            }else {
              this.loading = !this.loading;
              this.$emit('close');
              this.$buefy.toast.open({
                message: 'Inscription réussi. Vérifiez votre adresse mail en checkez vos mails',
                type: 'is-success'
              })
            }
          }
        }else{
          this.loading = false;
          this.message = 'Les mots de passe ne correspondent pas. Veuillez réessayez';
          this.targetMessage = "pwd";
        }
      }
    }
  }
</script>
