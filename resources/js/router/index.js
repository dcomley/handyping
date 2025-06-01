import { createRouter, createWebHistory } from 'vue-router';

// Import pages
import Dashboard from '../pages/Dashboard.vue';
import AddReminder from '../pages/AddReminder.vue';
import EditReminder from '../pages/EditReminder.vue';
import Login from '../pages/Login.vue';

const routes = [
  {
    path: '/',
    redirect: '/dashboard'
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
    meta: { guest: true }
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Dashboard,
    meta: { requiresAuth: true }
  },
  {
    path: '/reminders/add',
    name: 'add-reminder',
    component: AddReminder,
    meta: { requiresAuth: true }
  },
  {
    path: '/reminders/:id/edit',
    name: 'edit-reminder',
    component: EditReminder,
    meta: { requiresAuth: true }
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

// Navigation guard for auth
router.beforeEach((to, from, next) => {
  const isAuthenticated = localStorage.getItem('auth_token');
  
  if (to.meta.requiresAuth && !isAuthenticated) {
    next('/login');
  } else if (to.meta.guest && isAuthenticated) {
    next('/dashboard');
  } else {
    next();
  }
});

export default router; 