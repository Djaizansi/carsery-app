<template>
  <div class="flex items-center justify-center px-5 space-x-5 mb-5">
    <Card :car="car" :dates="car.chooseDate" type="payment" size="1/2"/>
  </div>
</template>
<script>
import Card from "../components/Card";

export default{
  components: { Card },
  data: () => ({car: {}}),
  created() {
    this.car = JSON.parse(localStorage.getItem('rent'));
  }
}

</script>
