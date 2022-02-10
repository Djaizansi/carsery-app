<template>
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
</template>
<script>
export default {
  name:"info-card-market"
}
</script>