<script setup>
import Tasks from '../components/Tasks.vue';
import { onMounted, ref } from 'vue';
import moment from 'moment';
import Paginate from '../components/Paginate.vue';
const userData = JSON.parse(sessionStorage.getItem('userData'));
const email = ref('');
const name = ref('');
onMounted(() => {
    email.value = userData?.email || '';
    name.value = userData?.name || '';
})

const selectedDate = ref(moment().format("YYYY-MM-DD"));

const handleDate = (dayNumber) => {
  selectedDate.value = moment(selectedDate.value).add(dayNumber, 'd').format("YYYY-MM-DD");

}

</script>
<template>
  <div class="home">
    <h1>Bienvenido al listado de tus tareas {{ name }}</h1>
    <Paginate @change-date="handleDate" :date="selectedDate"/>
    <Tasks :date="selectedDate"/>
  </div>
</template>
  
  <style>
  .home{
    margin-top: 3%;
  }
  </style>
  