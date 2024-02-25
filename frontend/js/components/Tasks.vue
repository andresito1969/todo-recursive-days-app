<script setup>
import { onMounted, ref, watch } from 'vue';
import axios from 'axios';
import AddTask from './AddTask.vue';
const userData = JSON.parse(sessionStorage.getItem('userData'));
const props = defineProps(['date']);
const date = ref(props.date);
const tasks = ref();

const getTaskRequest = (date) => {
    const getTaskReq = '/api/' + userData.user_id + '/task/' + date;
    axios.get(getTaskReq, {
        headers: {
            'Authorization' : userData.full_token
        }
    }).then(response => response.data.data.map((values)=> {
        values.isCompleted = !!values.completed;
        return values
    })).then(response => {
        tasks.value = response;
        return response;
    });
}

watch(() => props.date, (newDate) =>{
    getTaskRequest(newDate);
    date.value = newDate;
})

onMounted(() => {
    getTaskRequest(date.value);
});

const toggleChecked = (task) => {
    const patchTaskReq =  '/api/' + userData.user_id + '/task/' + task.id;
    task.completed = task.isCompleted ? 1 : 0;
    axios.patch(patchTaskReq, {
        'completed' : task.completed
    }, {
        headers: {'Authorization' : userData.full_token }
    });
}

const deleteTask = (selectedTask) => {
    const deleteTaskReq =  '/api/' + userData.user_id + '/task/' + selectedTask.id;
    axios.delete(deleteTaskReq, {
        headers: {
            'Authorization' : userData.full_token
        }
    }).then(res => {
        tasks.value = tasks.value.filter((task) => {
            return task.id !== selectedTask.id;
        });
        return res;
    });
}

const editTaskText = (task)  => {
    const patchTaskReq =  '/api/' + userData.user_id + '/task/' + task.id;
    axios.patch(patchTaskReq, {
        'text' : task.text
    }, {
        headers: {'Authorization' : userData.full_token }
    });
}
</script>
<template>
    <div>
        <h2>Tareas para la fecha: {{ date }}</h2>
        <div>
            <ul>
                <li v-for="task in tasks">
                    <input type="checkbox" v-model="task.isCompleted" 
                    @change="toggleChecked(task)"><input v-model="task.text"> 
                    <button @click="editTaskText(task)">editar</button>
                    <button @click="deleteTask(task)">borrar</button>
                </li>
            </ul>
        </div>
    </div>
    <AddTask :date="date" :tasks="tasks"/>
</template>