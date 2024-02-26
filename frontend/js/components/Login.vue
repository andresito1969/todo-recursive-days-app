<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
const router = useRouter();

const userMail = JSON.parse(sessionStorage.getItem('userMail'));
sessionStorage.removeItem('userMail');
const email = ref('');
const password = ref('');
const errorMessage = ref('');

onMounted(() => email.value = userMail?.email || '');

const loginUser = async () => {
  try {
    const data = { 
        email: email.value, 
        password: password.value 
    };
    const res = await axios.post('/api/login', data);
    sessionStorage.setItem('userData', JSON.stringify(res.data));
    window.dispatchEvent(new Event('login'));

    router.push('/');
  } catch (error) {
    errorMessage.value = error?.response?.data?.error
    setTimeout(() => errorMessage.value = "", 3000);
    console.error('Error al logear el usuario:', error);
  }
};

</script>

<template>
  <div class="login-container">
      <h1>Login</h1>
      <form @submit.prevent="loginUser">
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
        <button type="submit" class="btn btn-primary">Logear</button>
      </form>
      <div class="alert alert-danger" role="alert" v-if="errorMessage">
        {{ errorMessage }}
      </div>
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

.alert-danger {
  margin-top: 2%;
}
</style>