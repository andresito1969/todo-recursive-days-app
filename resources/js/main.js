import './bootstrap';

import {createApp} from 'vue';
// import Example from "./components/Example.vue";

import App from './App.vue'
import router from './router'

// const app = createApp({
//     components: {
//         Example,
//     }
// });

const app = createApp(App);

app.use(router)

app.mount("#app");