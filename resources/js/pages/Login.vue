<template>
  <div class="min-h-screen bg-gray-50 flex flex-col items-center justify-center px-4">
    <div class="max-w-md w-full space-y-8">
      <!-- Logo/Title -->
      <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">HandyPing</h1>
        <p class="text-gray-600">Never forget another licence renewal</p>
      </div>

      <!-- Phone Number Form -->
      <div v-if="!showCodeInput" class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">Sign in with your phone</h2>
        
        <form @submit.prevent="sendVerificationCode" class="space-y-6">
          <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
              Phone Number
            </label>
            <input
              id="phone"
              v-model="phone"
              type="tel"
              required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              placeholder="0412 345 678"
            />
          </div>

          <button
            type="submit"
            :disabled="sending"
            class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white font-semibold py-3 px-6 rounded-lg transition duration-200"
          >
            {{ sending ? 'Sending...' : 'Send Verification Code' }}
          </button>
        </form>
      </div>

      <!-- Verification Code Form -->
      <div v-else class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">Enter verification code</h2>
        <p class="text-sm text-gray-600 mb-6">We've sent a code to {{ phone }}</p>
        
        <form @submit.prevent="verifyCode" class="space-y-6">
          <div>
            <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
              6-digit code
            </label>
            <input
              id="code"
              v-model="code"
              type="text"
              maxlength="6"
              pattern="[0-9]{6}"
              required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-center text-2xl tracking-widest"
              placeholder="000000"
            />
          </div>

          <button
            type="submit"
            :disabled="verifying"
            class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white font-semibold py-3 px-6 rounded-lg transition duration-200"
          >
            {{ verifying ? 'Verifying...' : 'Verify Code' }}
          </button>

          <button
            type="button"
            @click="resetForm"
            class="w-full text-blue-600 hover:text-blue-800 font-medium py-2 transition duration-200"
          >
            Use a different phone number
          </button>
        </form>

        <!-- Debug code display (remove in production) -->
        <div v-if="debugCode" class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
          <p class="text-sm text-yellow-800">
            Debug: Your verification code is <span class="font-mono font-bold">{{ debugCode }}</span>
          </p>
        </div>
      </div>

      <!-- Features reminder -->
      <div class="text-center text-sm text-gray-600 space-y-2">
        <p>✓ No app installation required</p>
        <p>✓ SMS & Email reminders</p>
        <p>✓ 30-day free trial</p>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

export default {
  name: 'Login',
  setup() {
    const router = useRouter();
    const phone = ref('');
    const code = ref('');
    const showCodeInput = ref(false);
    const sending = ref(false);
    const verifying = ref(false);
    const debugCode = ref('');

    const sendVerificationCode = async () => {
      sending.value = true;
      
      try {
        const response = await axios.post('/verify-phone', { phone: phone.value });
        
        if (response.data.success) {
          showCodeInput.value = true;
          // Store debug code if provided (remove in production)
          debugCode.value = response.data.debug_code || '';
        }
      } catch (error) {
        console.error('Error sending verification code:', error);
        alert('Error sending verification code. Please try again.');
      } finally {
        sending.value = false;
      }
    };

    const verifyCode = async () => {
      verifying.value = true;
      
      try {
        const response = await axios.post('/verify-code', {
          phone: phone.value,
          code: code.value
        });
        
        if (response.data.success) {
          // Store auth token
          localStorage.setItem('auth_token', response.data.token);
          
          // Update axios headers
          window.axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
          
          // Redirect to dashboard
          router.push('/dashboard');
        }
      } catch (error) {
        console.error('Error verifying code:', error);
        alert(error.response?.data?.message || 'Invalid verification code. Please try again.');
        code.value = '';
      } finally {
        verifying.value = false;
      }
    };

    const resetForm = () => {
      showCodeInput.value = false;
      code.value = '';
      debugCode.value = '';
    };

    return {
      phone,
      code,
      showCodeInput,
      sending,
      verifying,
      debugCode,
      sendVerificationCode,
      verifyCode,
      resetForm
    };
  }
};
</script> 