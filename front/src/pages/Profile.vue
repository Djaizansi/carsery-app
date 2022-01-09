<template>

</template>

<script>
import axios from "axios";

export default {
  mounted() {
    const id = JSON.parse(this.$cookie.get('user_get')).id;
    axios.get(`http://localhost:3000/users/${id}`);
  }
}
</script>

<style>

</style>
