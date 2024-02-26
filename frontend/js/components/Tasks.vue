<script setup>
import { onMounted, ref, watch } from 'vue';
import axios from 'axios';
import AddTask from './AddTask.vue';
const userData = JSON.parse(sessionStorage.getItem('userData'));
const props = defineProps(['date']);
const date = ref(props.date);
const tasks = ref();
const modalTask = ref();

const getTaskRequest = (date) => {
    const getTaskReq = '/api/' + userData.user_id + '/task/' + date;
    axios.get(getTaskReq, {
        headers: {
            'Authorization' : userData.full_token
        }
    }).then(response => response.data.data.map((values)=> {
        //mapper needed in order to set true/false to boolean completed DDBB value
        // the reason is sql only saves 0 and 1, and our checkbox checked only checks for true and false, not for falsy values
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

const setModalTask = (task) => modalTask.value = task;
</script>
<template>
    <div class="tasks-container">
        <div v-for="task in tasks" class="row justify-content-md-center">
            <div class="col col-sm-2 text-end">
                <input type="checkbox" v-model="task.isCompleted" 
                @change="toggleChecked(task)" class="form-check-input check-item">
            </div>
            

            <div class="col-sm-6">
                <input v-model="task.text" class=" form-control"> 
            </div>
            <div class="col-sm-2 text-center">
                <button @click="setModalTask(task)" class="btn btn-primary"
                data-toggle="modal" data-target="#editModal"><i class="bi bi-pencil"></i></button>
            </div>
            <div class="col-sm-2 text-start">
                <button class="btn btn-primary" @click="setModalTask(task)"
                data-toggle="modal" data-target="#deleteModal"><i class="bi bi-trash"></i></button>
            </div>
        </div>
    </div>
    <AddTask :date="date" :tasks="tasks"/>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Estás seguro de que quieres borrar la tarea?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Esta acción es definitiva.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button @click="deleteTask(modalTask)" type="button" class="btn btn-danger"
                data-dismiss="modal">Borrar</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">La siguiente tarea va a ser editada.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma para guardar.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button @click="editTaskText(modalTask)" type="button" class="btn btn-success"
                data-dismiss="modal">Confirmar</button>
            </div>
            </div>
        </div>
    </div>
</template>

<style>
.tasks-container{
    margin-top: 3%;
}

.check-item {
    margin-top: 5%;
}

</style>