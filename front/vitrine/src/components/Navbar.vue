<template>
  <b-navbar class="p-4">
    <template #brand>
      <b-navbar-item tag="router-link" :to="{ path: '/' }">
        <img
            src="https://raw.githubusercontent.com/buefy/buefy/dev/static/img/buefy-logo.png"
            alt="Lightweight UI components for Vue.js based on Bulma"
        >
      </b-navbar-item>
    </template>
    <template #start>
      <b-navbar-item href="#">
        Home
      </b-navbar-item>
      <b-navbar-item href="#">
        Documentation
      </b-navbar-item>
    </template>

    <template #end>
      <b-navbar-item tag="div">
        <div class="buttons">
          <a class="button is-primary">
            <strong>Sign up</strong>
          </a>
          <b-dropdown
              position="is-bottom-left"
              aria-role="menu"
              trap-focus
          >
            <template #trigger>
              <b-button
                  label="Login"
                  icon-left="lock"
              />
            </template>
            <b-dropdown-item
                aria-role="menu-item"
                :focusable="false"
                custom
                paddingless>
              <form action="">
                <div class="modal-card mx-auto w-full lg:w-96">
                  <section class="modal-card-body">
                    <b-field label="Email">
                      <b-input
                          type="email"
                          placeholder="Your email"
                          required>
                      </b-input>
                    </b-field>

                    <b-field label="Password">
                      <b-input
                          type="password"
                          password-reveal
                          placeholder="Your password"
                          required>
                      </b-input>
                    </b-field>

                    <b-checkbox>Remember me</b-checkbox>
                  </section>
                  <footer class="modal-card-foot">
                    <b-button
                        label="Login"
                        type="is-primary" />
                  </footer>
                </div>
              </form>
            </b-dropdown-item>
          </b-dropdown>
        </div>
      </b-navbar-item>
    </template>
  </b-navbar>
</template>


<style lang="scss" scoped>

</style>
