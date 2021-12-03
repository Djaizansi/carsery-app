<template>
  <div>
    <Navbar />
    <Hero />
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

export default{
  components: {
    Navbar,
    Hero,
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
