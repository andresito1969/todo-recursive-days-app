<script setup>
import { ref } from 'vue';
import axios from 'axios';
const newTask = ref('');
const props = defineProps(['date', 'tasks']);
const userData = JSON.parse(sessionStorage.getItem('userData'));

const addTask = () => {
    const reqBody = {
        'text': newTask.value,
        'completed' : 0
    }
    const postTaskReq =  '/api/' + userData.user_id + '/task/' + props.date;
    axios.post(postTaskReq, reqBody, {
        headers: {'Authorization' : userData.full_token }
    }).then(response => {
        response.data.body.isCompleted = response.data.body.completed ? true : false;
        props.tasks.push(response.data.body);
    });
    newTask.value = ""
}
</script>

<template>
    <div>
        <input v-model="newTask">
        <button @click="addTask">Añade tarea</button>
    </div> 
</template>