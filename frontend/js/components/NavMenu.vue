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
    <ul class="nav justify-content-end bg-primary">
        <li class="nav-item">
            <a class="nav-link active">
                <RouterLink to="/">Home</RouterLink>
            </a>
        </li>
        <li class="nav-item" v-if="!isLoggedIn">
            <a class="nav-link active">
                <RouterLink to="/register">Registro</RouterLink>
            </a>
        </li>
        <li class="nav-item" v-if="!isLoggedIn">
            <a class="nav-link active">
                <RouterLink to="/login">Login</RouterLink>
            </a>
        </li>
        <li class="nav-item" v-if="isLoggedIn">
            <a class="nav-link active logout" @click="logout">
                Logout
            </a>
        </li>
    </ul>
</template>

<style>
.logout {
    text-decoration: underline;
    cursor: pointer;
    color: white;
}

.logout:hover {
    color: white;
    text-decoration: underline;
}

a {
    color: white;
}
</style>