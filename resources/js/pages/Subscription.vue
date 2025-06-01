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
          <h1 class="text-2xl font-bold text-gray-900">Subscription</h1>
        </div>
      </div>
    </header>

    <!-- Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Loading State -->
      <div v-if="loading" class="text-center py-12">
        <div class="inline-flex items-center">
          <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          <span class="ml-3 text-gray-600">Loading...</span>
        </div>
      </div>

      <!-- Active Subscription -->
      <div v-else-if="subscriptionStatus.has_subscription && !subscriptionStatus.on_grace_period" class="bg-white rounded-lg shadow p-6">
        <div class="text-center">
          <svg class="mx-auto h-12 w-12 text-green-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <h2 class="text-2xl font-bold text-gray-900 mb-2">You have an active subscription!</h2>
          <p class="text-gray-600 mb-6">Thank you for being a HandyPing Pro member.</p>
          
          <div class="space-y-4">
            <button @click="openBillingPortal" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
              Manage Billing
            </button>
            
            <div>
              <button @click="showCancelConfirm = true" class="text-red-600 hover:text-red-700 font-medium">
                Cancel Subscription
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Cancelled Subscription (Grace Period) -->
      <div v-else-if="subscriptionStatus.on_grace_period" class="bg-white rounded-lg shadow p-6">
        <div class="text-center">
          <svg class="mx-auto h-12 w-12 text-yellow-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
          </svg>
          <h2 class="text-2xl font-bold text-gray-900 mb-2">Subscription Cancelled</h2>
          <p class="text-gray-600 mb-2">Your subscription will end on {{ formatDate(subscriptionStatus.ends_at) }}</p>
          <p class="text-gray-600 mb-6">You'll continue to have access until then.</p>
          
          <button @click="resumeSubscription" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
            Resume Subscription
          </button>
        </div>
      </div>

      <!-- No Subscription -->
      <div v-else>
        <div class="bg-white rounded-lg shadow overflow-hidden">
          <!-- Pricing Header -->
          <div class="bg-blue-600 text-white text-center py-8 px-6">
            <h2 class="text-3xl font-bold mb-2">HandyPing Pro</h2>
            <p class="text-xl opacity-90">Never miss a renewal again</p>
          </div>
          
          <!-- Price -->
          <div class="text-center py-8 px-6">
            <div class="flex items-baseline justify-center">
              <span class="text-5xl font-bold text-gray-900">$9</span>
              <span class="text-gray-600 ml-2">/month</span>
            </div>
          </div>
          
          <!-- Features -->
          <div class="px-6 pb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Everything you need:</h3>
            <ul class="space-y-3">
              <li class="flex items-start">
                <svg class="w-5 h-5 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-gray-700">Unlimited reminders</span>
              </li>
              <li class="flex items-start">
                <svg class="w-5 h-5 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-gray-700">SMS notifications</span>
              </li>
              <li class="flex items-start">
                <svg class="w-5 h-5 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-gray-700">Email notifications</span>
              </li>
              <li class="flex items-start">
                <svg class="w-5 h-5 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-gray-700">Multiple alert timeframes</span>
              </li>
              <li class="flex items-start">
                <svg class="w-5 h-5 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-gray-700">Categories & notes</span>
              </li>
              <li class="flex items-start">
                <svg class="w-5 h-5 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-gray-700">Priority support</span>
              </li>
            </ul>
          </div>
          
          <!-- Subscribe Button -->
          <div class="px-6 pb-8">
            <button @click="startCheckout" :disabled="checkingOut" class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
              {{ checkingOut ? 'Processing...' : 'Subscribe Now' }}
            </button>
            <p class="text-center text-sm text-gray-600 mt-3">
              Cancel anytime. Secure payment via Stripe.
            </p>
          </div>
        </div>
      </div>

      <!-- Cancel Confirmation Modal -->
      <div v-if="showCancelConfirm" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
          <h3 class="text-lg font-semibold text-gray-900 mb-4">Cancel Subscription?</h3>
          <p class="text-gray-600 mb-6">Are you sure you want to cancel your subscription? You'll continue to have access until the end of your billing period.</p>
          
          <div class="flex space-x-3">
            <button @click="cancelSubscription" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
              Yes, Cancel
            </button>
            <button @click="showCancelConfirm = false" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg transition duration-200">
              Keep Subscription
            </button>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

export default {
  name: 'Subscription',
  setup() {
    const router = useRouter();
    const loading = ref(true);
    const checkingOut = ref(false);
    const subscriptionStatus = ref({});
    const showCancelConfirm = ref(false);

    const fetchSubscriptionStatus = async () => {
      try {
        const response = await axios.get('/subscription/status');
        subscriptionStatus.value = response.data.data;
      } catch (error) {
        console.error('Error fetching subscription status:', error);
      } finally {
        loading.value = false;
      }
    };

    const startCheckout = async () => {
      checkingOut.value = true;
      
      try {
        const response = await axios.post('/subscription/checkout');
        
        if (response.data.success && response.data.checkout_url) {
          // Redirect to Stripe checkout
          window.location.href = response.data.checkout_url;
        }
      } catch (error) {
        console.error('Error starting checkout:', error);
        alert(error.response?.data?.message || 'Failed to start checkout. Please try again.');
      } finally {
        checkingOut.value = false;
      }
    };

    const cancelSubscription = async () => {
      try {
        const response = await axios.post('/subscription/cancel');
        
        if (response.data.success) {
          showCancelConfirm.value = false;
          alert(response.data.message);
          // Refresh subscription status
          await fetchSubscriptionStatus();
        }
      } catch (error) {
        console.error('Error cancelling subscription:', error);
        alert(error.response?.data?.message || 'Failed to cancel subscription. Please try again.');
      }
    };

    const resumeSubscription = async () => {
      try {
        const response = await axios.post('/subscription/resume');
        
        if (response.data.success) {
          alert(response.data.message);
          // Refresh subscription status
          await fetchSubscriptionStatus();
        }
      } catch (error) {
        console.error('Error resuming subscription:', error);
        alert(error.response?.data?.message || 'Failed to resume subscription. Please try again.');
      }
    };

    const openBillingPortal = async () => {
      try {
        const response = await axios.post('/subscription/billing-portal');
        
        if (response.data.success && response.data.url) {
          window.location.href = response.data.url;
        }
      } catch (error) {
        console.error('Error opening billing portal:', error);
        alert('Failed to open billing portal. Please try again.');
      }
    };

    const formatDate = (dateString) => {
      if (!dateString) return '';
      return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
    };

    const goBack = () => {
      router.push('/dashboard');
    };

    onMounted(() => {
      fetchSubscriptionStatus();
    });

    return {
      loading,
      checkingOut,
      subscriptionStatus,
      showCancelConfirm,
      startCheckout,
      cancelSubscription,
      resumeSubscription,
      openBillingPortal,
      formatDate,
      goBack
    };
  }
};
</script> 