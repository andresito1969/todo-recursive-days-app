import { createRouter, createWebHistory } from 'vue-router'
import ExampleView from '../views/ExampleView.vue'
import TestView from '../views/TestView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: ExampleView
    },
    {
      path: '/mounted-data-view',
      name: 'mountedDataView',
      component: TestView
    }
  ]
})

export default router
