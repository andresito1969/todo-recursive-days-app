import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import RegisterView from '../views/RegisterView.vue'
import LoginView from '../views/LoginView.vue'

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
      component: RegisterView,
      meta: {
        requiresAuth: false
      }
    }, {
      path: '/login',
      name: 'login',
      component: LoginView,
      meta: {
        requiresAuth: false
      }
    }
  ]
})

router.beforeEach((to, from, next) => {
  const isAuthenticated = JSON.parse(sessionStorage.getItem('userData'));

  // if user is not auth and route requires auth, redirect to login
  if (to?.meta?.requiresAuth && !isAuthenticated) {
    next('/login'); 
  } 

  // if user is auth and route requires to exclusive not auth, stay in same page
  if(!to?.meta?.requiresAuth && isAuthenticated) {
    next(from.path)
  }

  next();
  
});

export default router
