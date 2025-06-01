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
          <h1 class="text-2xl font-bold text-gray-900">Test Email</h1>
        </div>
      </div>
    </header>

    <!-- Form -->
    <main class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="bg-white rounded-lg shadow p-6">
        <p class="text-gray-600 mb-6">Send a test email to verify your Mailgun configuration.</p>
        
        <form @submit.prevent="sendTestEmail" class="space-y-6">
          <!-- Email -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
              Email Address
            </label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              placeholder="your@email.com"
            />
          </div>

          <!-- Subject -->
          <div>
            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
              Subject (optional)
            </label>
            <input
              id="subject"
              v-model="form.subject"
              type="text"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              placeholder="Test Email from HandyPing"
            />
          </div>

          <!-- Message -->
          <div>
            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
              Message (optional)
            </label>
            <textarea
              id="message"
              v-model="form.message"
              rows="4"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              placeholder="This is a test email..."
            ></textarea>
          </div>

          <!-- Send Button -->
          <button
            type="submit"
            :disabled="sending"
            class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white font-semibold py-3 px-6 rounded-lg transition duration-200"
          >
            {{ sending ? 'Sending...' : 'Send Test Email' }}
          </button>
        </form>

        <!-- Result Message -->
        <div v-if="resultMessage" :class="[
          'mt-6 p-4 rounded-lg',
          resultSuccess ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800'
        ]">
          {{ resultMessage }}
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

export default {
  name: 'TestEmail',
  setup() {
    const router = useRouter();
    const sending = ref(false);
    const resultMessage = ref('');
    const resultSuccess = ref(false);
    
    const form = ref({
      email: '',
      subject: '',
      message: ''
    });

    const goBack = () => {
      router.push('/dashboard');
    };

    const sendTestEmail = async () => {
      sending.value = true;
      resultMessage.value = '';
      
      try {
        const response = await axios.post('/test-email', form.value);
        
        resultSuccess.value = true;
        resultMessage.value = response.data.message || 'Test email sent successfully!';
      } catch (error) {
        resultSuccess.value = false;
        resultMessage.value = error.response?.data?.message || 'Failed to send test email. Please check your configuration.';
      } finally {
        sending.value = false;
      }
    };

    return {
      form,
      sending,
      resultMessage,
      resultSuccess,
      goBack,
      sendTestEmail
    };
  }
};
</script> 