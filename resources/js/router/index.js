import { createRouter, createWebHistory } from 'vue-router';

// Import pages
import Dashboard from '../pages/Dashboard.vue';
import AddReminder from '../pages/AddReminder.vue';
import EditReminder from '../pages/EditReminder.vue';
import Login from '../pages/Login.vue';
import TestEmail from '../pages/TestEmail.vue';
import Subscription from '../pages/Subscription.vue';
import SubscriptionSuccess from '../pages/SubscriptionSuccess.vue';
import Landing from '../pages/Landing.vue';

const routes = [
  {
    path: '/',
    name: 'landing',
    component: Landing,
    meta: { guest: true }
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
  },
  {
    path: '/test-email',
    name: 'test-email',
    component: TestEmail,
    meta: { requiresAuth: true }
  },
  {
    path: '/subscription',
    name: 'subscription',
    component: Subscription,
    meta: { requiresAuth: true }
  },
  {
    path: '/subscription/success',
    name: 'subscription-success',
    component: SubscriptionSuccess,
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
  
  // Redirect authenticated users from landing to dashboard
  if (to.name === 'landing' && isAuthenticated) {
    next('/dashboard');
  } else if (to.meta.requiresAuth && !isAuthenticated) {
    next('/login');
  } else if (to.meta.guest && isAuthenticated && to.name !== 'landing') {
    next('/dashboard');
  } else {
    next();
  }
});

export default router; 