<template>
  <div>
    <Navbar />
    <Hero />
    <Section />
    <Section_2 />
    <Footer />
    <!--
    <button
        class="button is-primary"
        @click="test"
    >Test</button>
    <div v-if="data === ''">No img in data</div>
    <div v-for="(index,item) in data" :key="item">
      <img :src="index" alt="img"/>
    </div>
    -->
  </div>
</template>
<script>
import Navbar from './Navbar';
import Hero from './Hero';
import Section from "./Section";
import Section_2 from "./Section_2";
import Footer from "./Footer";

export default{
  components: {
    Footer,
    Navbar,
    Hero,
    Section,
    Section_2
  },
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
      const data = await res.json();
      this.data = data;
    }
  }
}

</script>
