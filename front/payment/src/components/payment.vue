<template>
  <div className="App">
    <stripe />
  </div>
</template>
<script>
import stripe from './stripe.vue';

export default{
  components: { stripe },
}

</script>