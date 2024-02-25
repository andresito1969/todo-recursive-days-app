<template>
    <div>
        <h1>Registro</h1>
        <form @submit.prevent="registerUser">
          <div>
            <label for="name">Nombre:</label>
            <input type="name" id="name" v-model="name">
          </div>
          <div>
              <label for="email">Email:</label>
              <input type="email" id="email" v-model="email">
          </div>
          <div>
              <label for="password">Contraseña:</label>
              <input type="password" id="password" v-model="password">
          </div>
          <button type="submit">Registrar</button>
        </form>
    </div>
</template>

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