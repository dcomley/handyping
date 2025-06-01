<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-6">
          <h1 class="text-2xl font-bold text-gray-900">HandyPing</h1>
          <div class="flex items-center space-x-4">
            <button @click="goToSubscription" class="text-sm text-gray-600 hover:text-gray-900">
              Subscription
            </button>
            <button @click="goToTestEmail" class="text-sm text-gray-600 hover:text-gray-900">
              Test Email
            </button>
            <button @click="logout" class="text-sm text-gray-600 hover:text-gray-900">
              Logout
            </button>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Welcome Section -->
      <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Welcome, {{ userName }}.</h2>
      </div>

      <!-- Expiring Soon Section -->
      <div v-if="expiringSoon.length > 0" class="mb-8">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Expiring soon</h3>
        <div class="space-y-4">
          <div v-for="reminder in expiringSoon" :key="reminder.id" 
               class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
              <div>
                <h4 class="text-lg font-semibold text-gray-900">{{ reminder.name }}</h4>
                <p class="text-sm text-gray-600">{{ reminder.days_left }} days left</p>
              </div>
              <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                Renew Now
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Upcoming Reminders Section -->
      <div class="mb-8">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Upcoming Reminders</h3>
        <div class="space-y-4">
          <div v-for="reminder in upcomingReminders" :key="reminder.id"
               @click="editReminder(reminder.id)"
               class="bg-white rounded-lg shadow-md p-6 cursor-pointer hover:shadow-lg transition duration-200">
            <div class="flex items-center justify-between">
              <div>
                <h4 class="text-lg font-semibold text-gray-900">{{ reminder.name }}</h4>
                <p class="text-sm text-gray-600">{{ reminder.days_until_expiry }} days</p>
              </div>
              <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </div>
          </div>

          <!-- Add New Reminder Button -->
          <div @click="addReminder"
               class="bg-white rounded-lg shadow-md p-6 cursor-pointer hover:shadow-lg transition duration-200 border-2 border-dashed border-gray-300">
            <div class="text-center">
              <p class="text-gray-600 font-medium">Add New Reminder</p>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Floating Add Button -->
    <button @click="addReminder"
            class="fixed bottom-8 right-8 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-4 shadow-lg transition duration-200">
      <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
      </svg>
    </button>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

export default {
  name: 'Dashboard',
  setup() {
    const router = useRouter();
    const userName = ref('Dan');
    const expiringSoon = ref([]);
    const upcomingReminders = ref([]);

    const fetchDashboardData = async () => {
      try {
        const response = await axios.get('/dashboard');
        if (response.data.success) {
          const data = response.data.data;
          userName.value = data.user.name === 'User' ? 'Dan' : data.user.name;
          expiringSoon.value = data.expiring_soon;
          upcomingReminders.value = data.upcoming_reminders;
        }
      } catch (error) {
        console.error('Error fetching dashboard data:', error);
      }
    };

    const addReminder = () => {
      router.push('/reminders/add');
    };

    const editReminder = (id) => {
      router.push(`/reminders/${id}/edit`);
    };

    const logout = async () => {
      try {
        await axios.post('/logout');
        localStorage.removeItem('auth_token');
        window.location.href = '/';
      } catch (error) {
        console.error('Logout error:', error);
      }
    };

    const goToSubscription = () => {
      router.push('/subscription');
    };

    const goToTestEmail = () => {
      router.push('/test-email');
    };

    onMounted(() => {
      fetchDashboardData();
    });

    return {
      userName,
      expiringSoon,
      upcomingReminders,
      addReminder,
      editReminder,
      logout,
      goToSubscription,
      goToTestEmail
    };
  }
};
</script> 