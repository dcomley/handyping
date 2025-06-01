<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center py-6">
          <button @click="goBack" class="mr-4">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
          </button>
          <h1 class="text-2xl font-bold text-gray-900">Edit Reminder</h1>
        </div>
      </div>
    </header>

    <!-- Form -->
    <main class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <form v-if="form" @submit.prevent="updateReminder" class="space-y-6">
        <!-- Reminder Name -->
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
            Reminder Name
          </label>
          <input
            id="name"
            v-model="form.name"
            type="text"
            required
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            placeholder="e.g., White Card Renewal"
          />
        </div>

        <!-- Expiry Date -->
        <div>
          <label for="expiry_date" class="block text-sm font-medium text-gray-700 mb-2">
            Expiry Date
          </label>
          <input
            id="expiry_date"
            v-model="form.expiry_date"
            type="date"
            required
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <!-- Alert Timeframe -->
        <div>
          <label for="alert_days_before" class="block text-sm font-medium text-gray-700 mb-2">
            Alert Timeframe
          </label>
          <select
            id="alert_days_before"
            v-model="form.alert_days_before"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          >
            <option value="1">1 day before</option>
            <option value="3">3 days before</option>
            <option value="7">7 days before</option>
            <option value="14">14 days before</option>
            <option value="30">30 days before</option>
            <option value="60">60 days before</option>
            <option value="90">90 days before</option>
          </select>
        </div>

        <!-- Notification Method -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Notification Method
          </label>
          <div class="flex space-x-4">
            <button
              type="button"
              @click="form.notification_method = 'sms'"
              :class="[
                'flex-1 py-3 px-4 rounded-lg font-medium transition duration-200',
                form.notification_method === 'sms' 
                  ? 'bg-blue-600 text-white' 
                  : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
              ]"
            >
              SMS
            </button>
            <button
              type="button"
              @click="form.notification_method = 'email'"
              :class="[
                'flex-1 py-3 px-4 rounded-lg font-medium transition duration-200',
                form.notification_method === 'email' 
                  ? 'bg-blue-600 text-white' 
                  : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
              ]"
            >
              Email
            </button>
          </div>
        </div>

        <!-- Category (optional) -->
        <div>
          <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
            Category (optional)
          </label>
          <input
            id="category"
            v-model="form.category"
            type="text"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            placeholder="e.g., License, Insurance, Certification"
          />
        </div>

        <!-- Notes (optional) -->
        <div>
          <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
            Notes (optional)
          </label>
          <textarea
            id="notes"
            v-model="form.notes"
            rows="3"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            placeholder="Any additional information..."
          ></textarea>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-3">
          <button
            type="submit"
            :disabled="saving"
            class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white font-semibold py-3 px-6 rounded-lg transition duration-200"
          >
            {{ saving ? 'Saving...' : 'Update Reminder' }}
          </button>
          
          <button
            type="button"
            @click="deleteReminder"
            :disabled="deleting"
            class="w-full bg-red-600 hover:bg-red-700 disabled:bg-red-400 text-white font-semibold py-3 px-6 rounded-lg transition duration-200"
          >
            {{ deleting ? 'Deleting...' : 'Delete Reminder' }}
          </button>
        </div>
      </form>
      
      <!-- Loading state -->
      <div v-else class="text-center py-8">
        <p class="text-gray-500">Loading reminder...</p>
      </div>
    </main>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';

export default {
  name: 'EditReminder',
  setup() {
    const router = useRouter();
    const route = useRoute();
    const saving = ref(false);
    const deleting = ref(false);
    const form = ref(null);
    const reminderId = route.params.id;

    const goBack = () => {
      router.push('/dashboard');
    };

    const fetchReminder = async () => {
      try {
        const response = await axios.get(`/reminders/${reminderId}`);
        if (response.data.success) {
          const reminder = response.data.data;
          form.value = {
            name: reminder.name,
            expiry_date: reminder.expiry_date.split('T')[0], // Format for date input
            alert_days_before: reminder.alert_days_before,
            notification_method: reminder.notification_method,
            category: reminder.category || '',
            notes: reminder.notes || ''
          };
        }
      } catch (error) {
        console.error('Error fetching reminder:', error);
        alert('Error loading reminder. Please try again.');
        router.push('/dashboard');
      }
    };

    const updateReminder = async () => {
      saving.value = true;
      
      try {
        const response = await axios.put(`/reminders/${reminderId}`, form.value);
        
        if (response.data.success) {
          router.push('/dashboard');
        }
      } catch (error) {
        console.error('Error updating reminder:', error);
        alert('Error updating reminder. Please try again.');
      } finally {
        saving.value = false;
      }
    };

    const deleteReminder = async () => {
      if (!confirm('Are you sure you want to delete this reminder?')) {
        return;
      }
      
      deleting.value = true;
      
      try {
        const response = await axios.delete(`/reminders/${reminderId}`);
        
        if (response.data.success) {
          router.push('/dashboard');
        }
      } catch (error) {
        console.error('Error deleting reminder:', error);
        alert('Error deleting reminder. Please try again.');
      } finally {
        deleting.value = false;
      }
    };

    onMounted(() => {
      fetchReminder();
    });

    return {
      form,
      saving,
      deleting,
      goBack,
      updateReminder,
      deleteReminder
    };
  }
};
</script> 