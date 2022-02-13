<template>
  <section class="flex flex-col items-center">
    <h1 class="text-center text-3xl font-bold mb-5">Mes véhicules</h1>
    <info-card-market/>
    <div class="w-full px-10">
      <table-custom :is-empty="isEmpty" :is-loading="isLoading" :data="data">
        <template v-for="(column,index) in columns">
          <b-table-column :key="index" v-bind="column">
            <template v-slot="props">
              <div v-if="column.field ==='status'">
                <div class="w-4 h-4 rounded-full flex justify-center items-center"
                     :class="props.row.status ? 'bg-green-500' : 'bg-yellow-500' "></div>
              </div>
              <div v-else-if="column.field === 'color'">
                <div class="flex justify-center">
                  <b-tag class="w-1/2" :style="{backgroundColor: props.row.color}"></b-tag>
                </div>
              </div>
              <div v-else-if="column.field === 'date'">
                <span class="tag is-success">{{ new Date(props.row.dateRegistration).toLocaleDateString() }}</span>
              </div>
              <div v-else-if="column.field === 'category' || column.field === 'model'">
                {{props.row[column.field].name}}
              </div>
              <div v-else-if="column.field === 'brand'">
                {{props.row.model[column.field].name}}
              </div>
              <div v-else-if="column.field === 'statusAdmin' && (user.roles.includes('ROLE_PRO') || user.roles.includes('ROLE_ADMIN'))">
                <div v-if="props.row.statusAdminCar ==='waiting' || props.row.statusAdminCar === 'raise'">
                  <p>En attente</p>
                </div>
                <div v-else-if="props.row.statusAdminCar ==='notFavorable'">
                  <b-button type="is-warning" @click="updateStatusAdmin(props.row.statusAdminCar,'raise',  props.row.id)">Relance</b-button>
                </div>
                <div v-else-if="props.row.statusAdminCar ==='validate' || props.row.statusAdminCar ==='admin'">
                  <div v-if="!props.row.rent">
                    <b-button icon-left="pencil" type="is-warning" @click="updateCar(props.row)">Modifier</b-button>
                  </div>
                  <b-button v-else icon-left="key" type="is-info" @click="updateCarRent(props)">Rendu ?</b-button>
                </div>
              </div>
              <div v-else>
                {{props.row[column.field]}}
              </div>
            </template>
          </b-table-column>
        </template>
      </table-custom>
    </div>
  </section>
</template>

<script>
import axios from "axios";
import InfoCardMarket from "../components/InfoCardMarket";
import TableCustom from "../components/TableCustom";
import TableColumnCar from "../Entity/Car/TableColumnCar";
import UpdateCar from "./UpdateCar";

export default {
  name: "ShowCarUser",
  components: {TableCustom, InfoCardMarket},
  created() {
    this.user = this.$store.state.user;
  },
  mounted() {
    this.isLoading = true;
    axios.get(`http://localhost:3000/cars?user=${this.user.id}`)
        .then(res => {
          if (res.data.length !== 0) {
            res.data.map(car => this.data.push(car))
          }
          this.isLoading = false;
        });
  },
  data: () => ({
    data: [],
    isEmpty: false,
    isLoading: false,
    user: {},
    columns: TableColumnCar,
    isComponentModalActive: false,
  }),
  methods: {
    updateStatusAdmin(status,type,id){
      if(status === "notFavorable") this.axiosUpdateStatus('raise',id);
    },
    axiosUpdateStatus(status,id){
      axios.put("http://localhost:3000/cars/"+id,{
        statusAdminCar: status
      })
          .then(res => {
            this.notification('Demande enregistré !','is-success');
            this.data.map(car => {
              if(car.id === res.data.id){
                car.statusAdminCar = res.data.statusAdminCar;
                car.status = res.data.status;
              }
            })
          });
    },
    notification(message,type) {
      if(type === "is-success") this.loading = false;
      this.$buefy.toast.open({
        message: message,
        type: type
      })
    },
    updateCar(car){
      this.$buefy.modal.open({
        parent: this,
        props:{car: car},
        component: UpdateCar,
        hasModalCard: true,
        customClass: 'custom-class custom-class-2',
        trapFocus: true
      })
    },
    updateCarRent(props){
      this.$buefy.dialog.confirm({
        title: 'Rendu du véhicule',
        cancelText: 'Non',
        confirmText: 'Oui',
        type: 'is-success',
        message: `Le véhicule a t-il été rendu ?`,
        onConfirm: () => {
          axios.put('http://localhost:3000/cars/'+props.row.id,{rent:false})
              .then(res => {
                props.row.rent = res.data.rent;
                this.notification('Le véhicule a été rendu !','is-success');
              });
        },
      })
    }
  }
}
</script>