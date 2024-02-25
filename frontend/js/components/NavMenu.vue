<script setup>
import { RouterLink, useRouter } from 'vue-router';
import { onMounted, ref } from 'vue';
const userData = JSON.parse(sessionStorage.getItem('userData'));
const isLoggedIn = ref(!!userData);
const router = useRouter();

const logout = () => {
    sessionStorage.clear();
    isLoggedIn.value = false;
    router.push('/login');
}

window.addEventListener('login', () => {
  isLoggedIn.value = true;
});

onMounted(() => {
    const userDataMounted = JSON.parse(sessionStorage.getItem('userData'));
    isLoggedIn.value = !!userDataMounted;
});
</script>

<template>
    <nav class="navbar navbar-expand navbar-light fixed-top">
        <div class="container">
            <RouterLink to="/">Home</RouterLink>
            <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item" v-if="!isLoggedIn">
                <RouterLink to="/register">Registro</RouterLink>
                </li>
                <li class="nav-item">
                <RouterLink to="/login" v-show="!isLoggedIn">Login</RouterLink>
                </li>
                <li class="nav-item">
                <button @click="logout" v-show="isLoggedIn">Logout</button>
                </li>
            </ul>
            </div>
        </div>
    </nav>
</template>

