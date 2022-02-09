<template>
  <section class="flex flex-col items-center">
    <h1 class="text-center text-3xl font-bold mb-5">Mes véhicules</h1>
    <div>
      <div class="flex items-center space-x-2">
        <div class="w-4 h-4 rounded-full bg-green-500"></div>
        <p>Disponible sur la Marketplace</p>
      </div>
      <div class="flex items-center space-x-2">
        <div class="w-4 h-4 rounded-full bg-yellow-500"></div>
        <p>Indisponible sur la Marketplace</p>
      </div>
    </div>
    <div class="w-full px-10">
      <b-table
          :data="isEmpty ? [] : data"
          :striped="true"
          :hoverable="true"
          :loading="isLoading"
          :focusable="true"
          :mobile-cards="true"
          class="mb-5"
      >
        <b-table-column field="status" v-slot="props">
          <div class="w-4 h-4 rounded-full flex justify-center items-center" :class="props.row.status ? 'bg-green-500' : 'bg-yellow-500' "></div>
        </b-table-column>

        <b-table-column field="category" label="Categorie" v-slot="props">
          {{ props.row.category.name }}
        </b-table-column>

        <b-table-column field="brand" label="Marque" v-slot="props">
          {{ props.row.model.brand.name }}
        </b-table-column>

        <b-table-column field="model" label="Modèle" v-slot="props">
          {{ props.row.model.name }}
        </b-table-column>

        <b-table-column field="color" label="Couleur" centered v-slot="props">
          <div class="flex justify-center">
            <b-tag class="w-1/2" :style="{backgroundColor: props.row.color}"></b-tag>
          </div>
        </b-table-column>

        <b-table-column field="kilometer" label="Kilomètrage (Km)" v-slot="props">
          {{ props.row.kilometer }}
        </b-table-column>

        <b-table-column field="numberplate" label="Plaque d'immatriculation" v-slot="props">
          {{ props.row.numberplate }}
        </b-table-column>

        <b-table-column field="power" label="Puissance (CH)" v-slot="props">
          {{ props.row.power }}
        </b-table-column>

        <b-table-column field="date" label="Date" centered
                        v-slot="props">
                <span class="tag is-success">
                    {{ new Date(props.row.date_registration).toLocaleDateString() }}
                </span>
        </b-table-column>

        <b-table-column field="price" label="Prix €/j" v-slot="props">
          {{ props.row.price }}
        </b-table-column>

        <b-table-column field="statusAdmin" label="Action" v-slot="props">
          <div v-if="props.row.statusAdminCar ==='waiting'"><p>En attente</p></div>
          <div v-else-if="props.row.statusAdminCar ==='notFavorable'">
            <b-button type="is-warning">Relance</b-button>
          </div>
          <div v-else-if="props.row.statusAdminCar ==='validate'">
            <b-icon
                icon="check-bold"
                size="is-medium"
                type="is-success">
            </b-icon>
          </div>
        </b-table-column>

        <template #empty>
          <div class="has-text-centered">No records</div>
        </template>
      </b-table>
    </div>
  </section>
</template>

<script>
import axios from "axios";
export default {
  name: "ShowCarUser",
  mounted() {
    this.isLoading = true;
    axios.get(`http://localhost:3000/cars?user=${this.$store.state.user.id}`)
        .then(res => {
          if(res.data.length !== 0){
            res.data.map(car => this.data.push(car))
            this.isLoading = false;
          }
        });
  },
  data: () =>  ({data:[],isEmpty:false,isBordered:false,isStriped:false,isNarrowed:false,isHoverable:false,isFocusable:false,isLoading:false,hasMobileCards:false}),
}
</script>