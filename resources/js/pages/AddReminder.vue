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
          <h1 class="text-2xl font-bold text-gray-900">Add Reminder</h1>
        </div>
      </div>
    </header>

    <!-- Form -->
    <main class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <form @submit.prevent="saveReminder" class="space-y-6">
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
            placeholder="MM/DD/YYYY"
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

        <!-- Save Button -->
        <button
          type="submit"
          :disabled="saving"
          class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white font-semibold py-3 px-6 rounded-lg transition duration-200"
        >
          {{ saving ? 'Saving...' : 'Save Reminder' }}
        </button>
      </form>
    </main>
  </div>
</template>

<script>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

export default {
  name: 'AddReminder',
  setup() {
    const router = useRouter();
    const saving = ref(false);
    
    const form = ref({
      name: '',
      expiry_date: '',
      alert_days_before: 7,
      notification_method: 'sms',
      category: '',
      notes: ''
    });

    const goBack = () => {
      router.push('/dashboard');
    };

    const saveReminder = async () => {
      saving.value = true;
      
      try {
        console.log('Submitting form data:', form.value);
        const response = await axios.post('/reminders', form.value);
        console.log('Response received:', response);
        
        // The API should return a success response
        if (response.status === 201 || response.data.success) {
          // Show success message briefly before redirecting
          alert('Reminder created successfully!');
          router.push('/dashboard');
        }
      } catch (error) {
        console.error('Error saving reminder:', error);
        console.error('Error response:', error.response);
        
        // Check for validation errors
        if (error.response?.status === 422) {
          const validationErrors = error.response.data.errors;
          let errorMessage = 'Validation errors:\n';
          for (const field in validationErrors) {
            errorMessage += `${field}: ${validationErrors[field].join(', ')}\n`;
          }
          alert(errorMessage);
        } else if (error.response?.status === 401) {
          alert('Your session has expired. Please log in again.');
          router.push('/login');
        } else {
          alert(error.response?.data?.message || 'Error saving reminder. Please try again.');
        }
      } finally {
        saving.value = false;
      }
    };

    return {
      form,
      saving,
      goBack,
      saveReminder
    };
  }
};
</script> 