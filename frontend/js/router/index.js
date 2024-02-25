import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import RegisterView from '../views/RegisterView.vue'
import LoginView from '../views/LoginView.vue'
import CreateTaskView from '../views/CreateTaskView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [{
      path: '/',
      name: 'home',
      component: HomeView,
      meta: {requiresAuth: true}
    }, {
      path: '/register',
      name: 'register',
      component: RegisterView
    }, {
      path: '/login',
      name: 'login',
      component: LoginView
    }, {
      path: '/create_task',
      name: 'createTask',
      component: CreateTaskView,
      meta: {requiresAuth: true}
    }
  ]
})

router.beforeEach((to, from, next) => {
  console.log("huh?")
  const isAuthenticated = JSON.parse(sessionStorage.getItem('userData'));
  if (to?.meta?.requiresAuth && !isAuthenticated) {
    next('/login'); 
  } else {
    next();
  }
});

export default router
