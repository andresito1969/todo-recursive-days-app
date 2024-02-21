<script setup>
import Example from '../components/Example.vue';
</script>
<template>
  <div class="about">
    <h1>This is an about page</h1>
    <Example/>
  </div>
</template>
  
  <style>
  @media (min-width: 1024px) {
    .about {
      min-height: 10px;
      align-items: center;
    }
  }
  </style>
  