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
    <div class="row justify-content-center add-task-container">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <div class="col-auto">
                    <input v-model="newTask" class="form-control mb-2">
                </div>
                <div class="col-auto button-item">
                    <button @click="addTask" class="btn btn-primary mb-2">Añade tarea</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.add-task-container{
    margin-top: 3%;
}

.button-item {
    margin-left: 5%;
}
</style>