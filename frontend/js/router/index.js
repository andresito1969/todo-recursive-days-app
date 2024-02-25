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
  const isValidRoute = checkValidRoute(to);

  // if user is not auth and route requires auth or is not valid route, redirect to login
  if ((to?.meta?.requiresAuth && !isAuthenticated) || !isValidRoute) {
    console.log("guard 1");
    next('/login'); 
  } 

  // if user is auth and route requires to exclusive not auth, stay in same page
  if(!to?.meta?.requiresAuth && isAuthenticated) {
    console.log("guard 2")
    next(from.path)
  }

  next();
});

const checkValidRoute = (to) => {
  let i = 0;
  let isValidRoute = false;
  console.log(router);
  while(i < router.options.routes.length && !isValidRoute) {
    const routeOption = router.options.routes[i];
    if(routeOption.path === to.path) {
      isValidRoute = true;
    }
    i++;
  }

  return isValidRoute;
}

export default router
