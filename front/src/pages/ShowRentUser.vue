<template>
  <div v-if="isLoading" class="is-flex is-justify-content-center w-full" ref="element">
    <b-loading :is-full-page="true" v-model="isLoading" :can-cancel="false"></b-loading>
  </div>
  <section v-else-if="!isLoading" class="flex flex-col items-center">
    <h1 class="text-center text-3xl font-bold mb-5">Mes locations</h1>
    <b-tabs v-model="activeTab" type="is-toggle-rounded" class="flex flex-col items-center">
      <template v-for="tab in tabs">
        <b-tab-item
            :key="tab.id"
            :value="tab.id"
            :icon="tab.icon"
            :label="tab.label"
        >
          <table-custom :is-empty="isEmpty" :data="tab.cars" class="mt-4">
            <template v-for="(column,index) in columns">
              <b-table-column :key="index" v-bind="column">
                <template v-slot="props">
                  <div v-if="column.field === 'color'">
                    <div class="flex justify-center">
                      <b-tag class="w-1/2" :style="{backgroundColor: props.row.color}"></b-tag>
                    </div>
                  </div>
                  <div v-else-if="column.field === 'date'">
                    <span class="tag is-success">{{ new Date(props.row.date_registration).toLocaleDateString() }}</span>
                  </div>
                  <div v-else-if="column.field === 'category' || column.field === 'model'">
                    {{ props.row[column.field].name }}
                  </div>
                  <div v-else-if="column.field === 'brand'">
                    {{ props.row.model[column.field].name }}
                  </div>
                  <div v-else-if="column.field === 'datesRent'">
                    {{ new Date(props.row[tab.id !== 'rent' ? column.field : 'chooseDate'][0]).toLocaleString().split(',')[0] }} au {{ new Date(props.row[tab.id !== 'rent' ? column.field : 'chooseDate'][1]).toLocaleString().split(',')[0] }}
                  </div>
                  <div v-else-if="column.field === 'show'" class="flex space-x-2">
                    <router-link :to="tab.id === 'rent' ? '/payment' : '/mes-locations/'+props.row.idBooking">
                      <b-button type="is-warning" :icon-left="tab.id === 'rent' ? 'credit-card-outline' : 'eye'">{{tab.id === 'rent' ? 'Payer' : 'Voir'}}</b-button>
                    </router-link>
                    <b-button v-if="tab.id === 'rent'" type="is-danger" icon-left="delete" @click="deleteRent"></b-button>
                  </div>
                  <div v-else>
                    {{ props.row[column.field] }}
                  </div>
                </template>
              </b-table-column>
            </template>
          </table-custom>
        </b-tab-item>
      </template>
    </b-tabs>
  </section>
</template>

<script>
import TableCustom from "../components/TableCustom";
import TableColumnCar from "../Entity/Car/TableColumnCar";
import axios from "axios";

export default {
  name: "ShowRentUser",
  components: {TableCustom},
  data: () => ({
    isEmpty: false,
    isLoading: null,
    user: null,
    columns: TableColumnCar.filter(column => column.hasOwnProperty('role') && column.role === 'all'),
    activeTab: null,
    roles: null,
    tabs: null
  }),
  created() {
    this.user = this.$store.state.user;
    this.roles = this.user.roles;
    this.isLoading = true;
    this.columns = [...this.columns,
      {
        field: 'datesRent',
        label: 'Date reservation',
      },
      {
        field: 'show'
      }
    ];
  },
  mounted() {
    this.baseTabs.map(tabs => {
      if(tabs.id !== 'rent'){
        this.activeTabsCar(tabs.id)
            .then(data => {
              tabs.cars = data;
              console.log(data);
              this.isLoading = false;
            });
      }else{
        tabs.cars = localStorage.getItem('rent') !== null ? [JSON.parse(localStorage.getItem('rent'))] : []
      }
    });
    this.tabs = [...this.baseTabs];
  },
  computed: {
    baseTabs() {
      return [
        {
          id: 'rent',
          label: 'Réservation',
          icon: "car-key"
        },
        {
          id: 'now',
          label: 'En cours',
          icon: "timer-sand"
        },
        {
          id: 'historic',
          label: 'Historique',
          icon: "timer-sand-full"
        }
      ]
    }
  },
  methods: {
    activeTabsCar(type) {
      return axios.get(`http://localhost:3000/getCarsByUserByBooking/${this.user.id}?type=${type}`)
          .then(res => res.data);
    },
    deleteRent(){
      localStorage.removeItem('rent');
      this.tabs.map(tab => {
        if(tab.id === 'rent'){
          tab.cars = [];
        }
      });
      this.$buefy.toast.open({
        message: 'Réservation annulé !',
        type: 'is-success'
      })
    }
  }
}
</script>