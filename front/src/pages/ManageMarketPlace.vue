<template>
  <section class="flex flex-col items-center">
    <h1 class="text-center text-3xl font-bold mb-5">Gestion MarketPlace</h1>
    <div class="w-full px-10">
      <table-custom :is-loading="isLoading" :is-empty="isEmpty" :data="data">
        <b-table-column field="company" label="Utilisateur" v-slot="props">
          {{ props.row.company }}
        </b-table-column>

        <b-table-column field="length" label="Nombre de voiture" v-slot="props">
          {{ props.row.cars.length }}
        </b-table-column>

        <b-table-column field="action" label="Action" v-slot="props">
          <b-button type="is-warning" icon-left="eye" @click="showUserCarPro(props)"/>
        </b-table-column>
      </table-custom>
    </div>
  </section>
</template>
<script>
import axios from "axios";
import TableCustom from "../components/TableCustom";

export default {
  name:"ManageMarketPlace",
  components: {TableCustom},
  data: () => ({
    data:[],
    isEmpty:false,
    isLoading:false,
    user: {}
  }),
  mounted() {
    this.isLoading = true;
    axios.get('http://localhost:3000/getAllCarByPro')
        .then(res => {
          if(res.data.length !== 0){
            this.data = res.data;
            console.log(this.data);
          }
          this.isLoading = false;
        });
  },
  methods: {
    showUserCarPro(props){
      this.user = props.row;
      this.$router.push({name:'gestionMarketPlaceByCarsUser',params:{user:this.user}});
    }
  }
}
</script>