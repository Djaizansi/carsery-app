<template>
  <div>
    <Hero />
    <div class="columns is-mobile is-centered is-vcentered">
      <div class="column">
        <img src="https://www.svgrepo.com/show/24109/car.svg" alt="car" class="img">
      </div>
      <div class="column">
        <div data-aos="fade-down" class="">
          <h1 class="titled title is-2 mb-6">
            Un tout nouveau système &#128175;
          </h1>
          <h2 class="subtitled subtitle m-1">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laborum cupiditate dolorum vitae dolores
            nesciunt totam magni quas. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laborum cupiditate dolorum vitae dolores
            nesciunt totam magni quas.
          </h2>
        </div>
      </div>
    </div>
    <div class="columns is-mobile is-centered is-vcentered">
      <div class="column" data-aos="fade-left">
        <img src="https://www.svgrepo.com/show/138892/users.svg" alt="user" class="img">
      </div>
      <div class="column">
        <div data-aos="fade-down" class="">
          <h1 class="titled title is-2 mb-6">
            Pour tout le monde, même les débutants &#128513;
          </h1>
          <h2 class="subtitled subtitle m-1">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laborum cupiditate dolorum vitae dolores
            nesciunt totam magni quas. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laborum cupiditate dolorum vitae dolores
            nesciunt totam magni quas.
          </h2>
        </div>
      </div>
    </div>
    <!--
    <section class="hero is-white is-fullheight">
      <div class="hero-body" data-aos="zoom-in-down">
        <div class="container">
          <div class="columns is-vcentered">
            <div data-aos="fade-left" class="column
          is-10-mobile is-offset-1-mobile
          is-10-tablet is-offset-1-tablet
          is-4-desktop is-offset-1-desktop
          is-4-widescreen is-offset-1-widescreen
          is-4-fullhd is-offset-1-fullhd">
              <figure class="image is-square">
                <img src="https://www.svgrepo.com/show/24109/car.svg" alt="car">
              </figure>
            </div>
            <div data-aos="fade-down" class="">
              <h1 class="titled title is-2 mb-6">
                Un tout nouveau système &#128175;
              </h1>
              <h2 class="subtitled subtitle m-1">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laborum cupiditate dolorum vitae dolores
                nesciunt totam magni quas. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laborum cupiditate dolorum vitae dolores
                nesciunt totam magni quas.
              </h2>
            </div>

          </div>
        </div>
      </div>
    </section>
    <section class="hero is-white is-fullheight">
      <div class="hero-body" data-aos="zoom-in-left">
        <div class="container">
          <div class="columns  is-vcentered reverse-columns">
            <div data-aos="fade-right" class="column
          is-10-mobile is-offset-1-mobile
          is-10-tablet is-offset-1-tablet
          is-5-desktop is-offset-1-desktop
          is-5-widescreen is-offset-1-widescreen
          is-5-fullhd is-offset-1-fullhd">
              <h1 class="title titled is-2 mb-6">
                Pour tout le monde, même les débutants &#128513;
              </h1>
              <h2 class="subtitle subtitled m-1">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laborum cupiditate dolorum vitae dolores
                nesciunt totam magni quas.
              </h2>
            </div>
            <div data-aos="fade-down" class="column
          is-10-mobile is-offset-1-mobile
          is-10-tablet is-offset-1-tablet
          is-4-desktop is-offset-1-desktop
          is-4-widescreen is-offset-1-widescreen
          is-4-fullhd is-offset-1-fullhd">
              <figure class="image is-square">
                <img src="https://www.svgrepo.com/show/138892/users.svg" alt="user">
              </figure>
            </div>
          </div>
        </div>
      </div>
    </section>
    -->

  </div>
</template>
<script>
import Hero from '../components/Hero';

export default{
  name: "Home",
  components: {Hero},
  data: () => ({data: ""}),
  methods: {
    async test(){
      const res = await fetch("http://localhost:8300/download/list", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({filePath:"voitures/"})
      });
      this.data = await res.json();
    }
  }
}

</script>

<style>

.img {
  height: 30em;
}

@media only screen and (min-width: 1100px) {
  .img {
    margin-left: 5em;
  }
}

</style>