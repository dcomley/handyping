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
      <div v-if="expiringSoon.length > 0" class="mb-12">
        <h3 class="text-xl font-semibold text-gray-900 mb-6">Expiring Soon</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <div v-for="reminder in expiringSoon" :key="reminder.id" 
               class="bg-red-50 border border-red-200 rounded-lg p-6">
            <div class="space-y-3">
              <div class="flex justify-between items-start">
                <h4 class="text-lg font-medium text-gray-900">{{ reminder.name }}</h4>
                <button @click="deleteReminder(reminder)" 
                        class="text-red-600 hover:text-red-800 transition-colors">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                  </svg>
                </button>
              </div>
              <div class="space-y-1 text-sm">
                <p class="text-gray-600">
                  <span class="font-medium">Expiry:</span> {{ formatDate(reminder.expiry_date) }}
                </p>
                <p class="text-red-600 font-medium">{{ reminder.days_left }} days left</p>
              </div>
              <button class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                Renew Now
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- All Reminders Section -->
      <div>
        <div class="flex justify-between items-center mb-6">
          <h3 class="text-xl font-semibold text-gray-900">All Reminders</h3>
          <button @click="addReminder"
                  class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span>Add Reminder</span>
          </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <div v-for="reminder in allReminders" :key="reminder.id"
               class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 p-6 border border-gray-200">
            <div class="space-y-3">
              <div class="flex justify-between items-start">
                <h4 class="text-lg font-medium text-gray-900">{{ reminder.name }}</h4>
                <div class="flex space-x-2">
                  <button @click="editReminder(reminder.id)" 
                          class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                  </button>
                  <button @click="deleteReminder(reminder)" 
                          class="text-gray-400 hover:text-red-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                  </button>
                </div>
              </div>
              <div class="space-y-1 text-sm">
                <p class="text-gray-600">
                  <span class="font-medium">Expiry:</span> {{ formatDate(reminder.expiry_date) }}
                </p>
                <p class="text-gray-600">
                  <span class="font-medium">Lead Time:</span> {{ reminder.lead_time }} days
                </p>
                <p :class="getReminderStatusClass(reminder)">
                  {{ getReminderStatus(reminder) }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
      <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
          <svg class="mx-auto mb-4 w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
          </svg>
          <h3 class="text-lg leading-6 font-medium text-gray-900">Delete Reminder</h3>
          <div class="mt-2 px-7 py-3">
            <p class="text-sm text-gray-500">
              Are you sure you want to delete the reminder "{{ reminderToDelete?.name }}"?
            </p>
          </div>
          <div class="flex justify-center space-x-4 mt-4">
            <button @click="cancelDelete" 
                    class="px-4 py-2 bg-gray-200 text-gray-800 text-base font-medium rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300">
              Cancel
            </button>
            <button @click="confirmDelete" 
                    class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
              Delete
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, computed } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import moment from 'moment';

export default {
  name: 'Dashboard',
  setup() {
    const router = useRouter();
    const userName = ref('Dan');
    const expiringSoon = ref([]);
    const upcomingReminders = ref([]);
    const showDeleteModal = ref(false);
    const reminderToDelete = ref(null);

    const allReminders = computed(() => {
      // Combine all reminders and sort by expiry date
      const all = [...expiringSoon.value, ...upcomingReminders.value];
      return all.sort((a, b) => new Date(a.expiry_date) - new Date(b.expiry_date));
    });

    const formatDate = (date) => {
      return moment(date).format('D MMM YYYY');
    };

    const getReminderStatus = (reminder) => {
      const daysLeft = reminder.days_left || reminder.days_until_expiry;
      if (daysLeft < 0) {
        return `Expired ${Math.abs(daysLeft)} days ago`;
      } else if (daysLeft === 0) {
        return 'Expires today';
      } else if (daysLeft === 1) {
        return '1 day left';
      } else {
        return `${daysLeft} days left`;
      }
    };

    const getReminderStatusClass = (reminder) => {
      const daysLeft = reminder.days_left || reminder.days_until_expiry;
      if (daysLeft < 0) {
        return 'text-red-600 font-medium';
      } else if (daysLeft <= 7) {
        return 'text-orange-600 font-medium';
      } else if (daysLeft <= 30) {
        return 'text-yellow-600';
      } else {
        return 'text-green-600';
      }
    };

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

    const deleteReminder = (reminder) => {
      reminderToDelete.value = reminder;
      showDeleteModal.value = true;
    };

    const confirmDelete = async () => {
      try {
        await axios.delete(`/reminders/${reminderToDelete.value.id}`);
        showDeleteModal.value = false;
        reminderToDelete.value = null;
        // Refresh the dashboard data
        await fetchDashboardData();
      } catch (error) {
        console.error('Error deleting reminder:', error);
        alert('Failed to delete reminder. Please try again.');
      }
    };

    const cancelDelete = () => {
      showDeleteModal.value = false;
      reminderToDelete.value = null;
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
      allReminders,
      showDeleteModal,
      reminderToDelete,
      formatDate,
      getReminderStatus,
      getReminderStatusClass,
      addReminder,
      editReminder,
      deleteReminder,
      confirmDelete,
      cancelDelete,
      logout,
      goToSubscription,
      goToTestEmail
    };
  }
};
</script> 