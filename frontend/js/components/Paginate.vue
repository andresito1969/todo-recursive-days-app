<script setup>
import { ref } from 'vue';
const emit = defineEmits(['change-date'])
const nextDay = () => {
  emit('change-date', 1);
};

const prevDay = () => {
  emit('change-date', -1);
};
</script>

<template>
    <button @click="prevDay">Previo</button>
    <button @click="nextDay">Siguiente</button>
  </template>