<script setup>
import { ref } from 'vue';

const userData = JSON.parse(sessionStorage.getItem('userData'));
const email = userData?.email ?? '';
</script>
<template>
    <h1>Example Component {{ email }}</h1>
</template>