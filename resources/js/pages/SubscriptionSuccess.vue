<template>
  <div class="min-h-screen bg-gray-50 flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
      <div class="bg-white rounded-lg shadow-lg p-8 text-center">
        <!-- Success Icon -->
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
          <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
        </div>
        
        <!-- Success Message -->
        <h1 class="text-2xl font-bold text-gray-900 mb-4">Welcome to HandyPing Pro!</h1>
        <p class="text-gray-600 mb-8">Your subscription is now active. You have access to all premium features.</p>
        
        <!-- Actions -->
        <div class="space-y-3">
          <button @click="goToDashboard" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
            Go to Dashboard
          </button>
          
          <button @click="addFirstReminder" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-3 px-6 rounded-lg transition duration-200">
            Add Your First Reminder
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useRouter } from 'vue-router';

export default {
  name: 'SubscriptionSuccess',
  setup() {
    const router = useRouter();
    
    const goToDashboard = () => {
      router.push('/dashboard');
    };
    
    const addFirstReminder = () => {
      router.push('/reminders/add');
    };
    
    return {
      goToDashboard,
      addFirstReminder
    };
  }
};
</script> 