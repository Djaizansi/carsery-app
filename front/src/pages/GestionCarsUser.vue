<template>
  <section class="flex flex-col items-center">
    <h1 class="text-center text-3xl font-bold mb-5">Voiture de {{user.company}}</h1>
    <info-card-market />
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
              <div v-else-if="column.field === 'statusAdmin'">
                <div v-if="props.row.statusAdminCar ==='waiting'">
                  <div class="flex space-x-2">
                    <b-button type="is-success" icon-left="check" @click="updateStatusAdmin(props.row.statusAdminCar,'success', props.row.id)"/>
                    <b-button type="is-danger" icon-left="close-thick" @click="updateStatusAdmin(props.row.statusAdminCar,'reject', props.row.id)"/>
                  </div>
                </div>
                <div v-if="props.row.statusAdminCar ==='notFavorable'">
                  <p>En cours</p>
                </div>
                <div v-else-if="props.row.statusAdminCar ==='raise'">
                  <div class="flex space-x-2">
                    <b-button type="is-success" icon-left="check" @click="updateStatusAdmin(props.row.statusAdminCar,'success', props.row.id)"/>
                    <b-button type="is-danger" icon-left="delete" @click="updateStatusAdmin(props.row.statusAdminCar,'delete', props.row.id)"/>
                  </div>
                </div>
                <div v-else-if="props.row.statusAdminCar ==='validate'">
                  <b-icon
                      icon="check-bold"
                      size="is-medium"
                      type="is-success">
                  </b-icon>
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
import InfoCardMarket from "../components/InfoCardMarket";
import TableCustom from "../components/TableCustom";
import TableColumnCar from "../Entity/Car/TableColumnCar";
import axios from "axios";

export default {
  name: "GestionCarsUser",
  components: {TableCustom, InfoCardMarket},
  mounted() {
    this.isLoading = true;
    this.user = this.$route.params.user;
    setTimeout(() => {
      this.user.cars.map(car => this.data.push(car));
      this.isLoading = false;
    }, 1000);
  },
  data: () =>  ({
    data:[],
    isEmpty:false,
    isLoading:false,
    user:{},
    columns: TableColumnCar
  }),
  methods: {
    updateStatusAdmin(status,type,id){
      if(status === "waiting" && type === "reject") this.axiosUpdateStatus('notFavorable',id);
      else if(status === "raise" && type === "delete")this.axiosDeleteCar(id);
      else this.axiosUpdateStatus('validate',id);
    },
    axiosUpdateStatus(status,id){
      axios.put("http://localhost:3000/cars/"+id,{
        statusAdminCar: status,
        status: status === "validate" && true
      })
          .then(res => {
            console.log(res);
            this.notification('Demande enregistré !','is-success');
            this.data.map(car => {
              if(car.id === res.data.id){
                car.statusAdminCar = res.data.statusAdminCar;
                car.status = res.data.status;
              }
            })
          });
    },
    axiosDeleteCar(id){
      axios.delete("http://localhost:3000/cars/"+id)
          .then(res => {
            console.log(res);
            if(res.status === 204){
              this.notification('Suppression du véhicule réussi !','is-success');
              this.data.map((car,index) => {
                if(car.id === id){
                  this.data.splice(index,1);
                }
              });
            }
          });
    },
    notification(message,type) {
      if(type === "is-success") this.loading = false;
      this.$buefy.toast.open({
        message: message,
        type: type
      })
    },
  }
}
</script>