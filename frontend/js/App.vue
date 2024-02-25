<script setup>
import NavMenu from './components/NavMenu.vue'
import {RouterView} from 'vue-router';
</script>

<template>
  <NavMenu/>
  <div class="container">
    <RouterView />
  </div>
</template>

<style scoped>
  .auth-wrapper {
    margin-top: 3%;
  }
</style>
