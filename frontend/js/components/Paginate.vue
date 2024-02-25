<script setup>
import { ref } from 'vue';
const emit = defineEmits(['change-date'])
const props = defineProps(['date']);

const nextDay = () => {
  emit('change-date', 1);
};

const prevDay = () => {
  emit('change-date', -1);
};
</script>

<template>
  <div class="row justify-content-md-center">
    <div class="col col-lg-1">
      <button class="btn btn-primary"
      @click="prevDay">Previo</button>
    </div>
    <div class="col-md-auto">
      <h3>{{ props.date }}</h3>
    </div>
    <div class="col col-lg-1">
      <button @click="nextDay"
      class="btn btn-primary">Siguiente</button>
    </div>
  </div>
</template>