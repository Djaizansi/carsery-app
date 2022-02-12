<template>
  <b-table
      :data="isEmpty ? [] : updateCars"
      :striped="true"
      :hoverable="true"
      :loading="isLoading"
      :focusable="true"
      :mobile-cards="true"
      class="mb-5"
  >
    <slot></slot>
    <template #empty>
      <div class="has-text-centered">Aucune donnée</div>
    </template>
  </b-table>
</template>

<script>
export default {
  name:"table-custom",
  props: {
    isEmpty: Boolean,
    data: Array,
    isLoading: Boolean
  },
  computed: {
    updateCars() {
      return this.data;
    }
  }
}
</script>