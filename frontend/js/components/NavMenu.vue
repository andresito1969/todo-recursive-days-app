<script setup>
import { RouterLink, useRouter } from 'vue-router';
import { onMounted, ref } from 'vue';
const userData = JSON.parse(sessionStorage.getItem('userData'));
const isLoggedIn = ref(!!userData);
const router = useRouter();

console.log('isLog', isLoggedIn);

const logout = () => {
    sessionStorage.clear();
    router.push('/login');
}

onMounted(() => {
    // another scope thats why we can use userData const
    const userData = JSON.parse(sessionStorage.getItem('userData'));
    isLoggedIn.value = !!userData;
    console.log('mount', isLoggedIn.value);
});
</script>

<template>
    <nav class="navbar navbar-expand navbar-light fixed-top">
        <div class="container">
            <RouterLink to="/">Home</RouterLink>
            <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item" v-if="!isLoggedIn">
                <RouterLink to="/register">Register</RouterLink>
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

