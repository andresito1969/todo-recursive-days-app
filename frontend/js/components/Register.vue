<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
const router = useRouter();

const email = ref('');
const name = ref('');
const password = ref('');

const registerUser = async () => {
  try {
    const data = { 
        name: name.value,
        email: email.value, 
        password: password.value 
    };
    await axios.post('/api/register', data);
    sessionStorage.setItem('userMail', JSON.stringify({email: email.value}));
    router.push('/login', data);
  } catch (error) {
    console.error('Error al registrar el usuario:', error);
  }
};

</script>

<template>
  <div class="login-container">
      <h1>Registro</h1>
      <form @submit.prevent="registerUser">
        <div class="form-group">
          <label for="name">Nombre:</label>
          <input type="text" id="name" 
          class="form-control" v-model="name">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" 
            class="form-control" v-model="email">
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" 
            class="form-control" v-model="password">
        </div>
        <button type="submit" class="btn btn-primary">Registrar</button>
      </form>
  </div>
</template>

<style>
.login-container{
  margin-top: 4%;
}

.form-group{
  margin-top: 2%;
}

.btn-primary{
  margin-top: 2%;
}
</style>