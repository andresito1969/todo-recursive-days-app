<template>
    <div>
        <h1>Login</h1>
        <form @submit.prevent="loginUser">
          <div>
              <label for="email">Email:</label>
              <input type="email" id="email" v-model="email">
          </div>
          <div>
              <label for="password">Contraseña:</label>
              <input type="password" id="password" v-model="password">
          </div>
          <button type="submit">Logear</button>
        </form>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
const router = useRouter();

const userMail = JSON.parse(sessionStorage.getItem('userMail'));
sessionStorage.removeItem('userMail');
const email = ref('');
const password = ref('');

onMounted(() => email.value = userMail?.email || '');

const loginUser = async () => {
  try {
    const data = { 
        email: email.value, 
        password: password.value 
    };
    const res = await axios.post('/api/login', data);
    sessionStorage.setItem('userData', JSON.stringify(res.data));
    router.push('/');
  } catch (error) {
    console.error('Error al registrar el usuario:', error);
  }
};

</script>