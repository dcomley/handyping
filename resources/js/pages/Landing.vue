<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-6">
          <h1 class="text-2xl font-bold text-gray-900">HandyPing</h1>
          <div class="flex items-center space-x-4">
            <router-link to="/login" class="text-sm text-gray-600 hover:text-gray-900">
              Login
            </router-link>
            <router-link to="/login" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition duration-200">
              Start Free Trial
            </router-link>
          </div>
        </div>
      </div>
    </header>

    <!-- Hero Section -->
    <section class="pt-20 pb-16 px-4">
      <div class="max-w-7xl mx-auto text-center">
        <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6">
          Never forget another<br>license renewal
        </h1>
        <p class="text-xl md:text-2xl text-gray-600 mb-10 max-w-3xl mx-auto">
          Simple SMS & email reminders for your trade licenses, insurance, and certifications. 
          Built for Aussie tradies who have better things to worry about.
        </p>
        
        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
          <router-link to="/login" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-8 rounded-lg transition duration-200 text-lg">
            Start 30-Day Free Trial
          </router-link>
          <router-link to="/login" class="bg-gray-200 hover:bg-gray-300 text-gray-900 font-semibold py-4 px-8 rounded-lg transition duration-200 text-lg">
            Add Your First Reminder
          </router-link>
        </div>

        <!-- Trust Badges -->
        <div class="flex flex-wrap justify-center gap-6 text-sm text-gray-600">
          <span class="flex items-center">
            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            No credit card required
          </span>
          <span class="flex items-center">
            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Cancel anytime
          </span>
          <span class="flex items-center">
            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Only $9/month after trial
          </span>
        </div>
      </div>
    </section>

    <!-- Demo Card -->
    <section class="py-16 px-4 bg-white">
      <div class="max-w-4xl mx-auto">
        <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">
          Never miss important dates again
        </h2>
        
        <!-- Example Reminder Cards -->
        <div class="grid md:grid-cols-2 gap-6 mb-12">
          <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
            <div class="flex items-start justify-between mb-4">
              <div>
                <h3 class="text-lg font-semibold text-gray-900">White Card Renewal</h3>
                <p class="text-sm text-gray-600">Expires: 10 Aug 2025</p>
              </div>
              <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                3 days left
              </span>
            </div>
            <div class="flex items-center text-sm text-gray-600">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
              </svg>
              SMS reminder scheduled
            </div>
          </div>

          <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
            <div class="flex items-start justify-between mb-4">
              <div>
                <h3 class="text-lg font-semibold text-gray-900">Public Liability Insurance</h3>
                <p class="text-sm text-gray-600">Expires: 15 Dec 2024</p>
              </div>
              <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                30 days left
              </span>
            </div>
            <div class="flex items-center text-sm text-gray-600">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
              </svg>
              Email reminder scheduled
            </div>
          </div>
        </div>

        <!-- Features Grid -->
        <div class="grid md:grid-cols-3 gap-8 text-center">
          <div>
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
              </svg>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">SMS Alerts</h3>
            <p class="text-sm text-gray-600">Get reminders straight to your phone - no app needed</p>
          </div>
          
          <div>
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
              </svg>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Email Backup</h3>
            <p class="text-sm text-gray-600">Important reminders also sent to your email</p>
          </div>
          
          <div>
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
              </svg>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Track Everything</h3>
            <p class="text-sm text-gray-600">Licenses, insurance, rego, certifications - all in one place</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 px-4 bg-gray-50">
      <div class="max-w-4xl mx-auto">
        <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">
          What tradies are saying
        </h2>
        
        <div class="grid md:grid-cols-3 gap-8">
          <div class="bg-white rounded-lg p-6 shadow-sm">
            <div class="flex mb-4">
              <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" v-for="i in 5" :key="i">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
              </svg>
            </div>
            <blockquote class="text-gray-700 mb-4">
              "Bloody life-saver. Nearly forgot my White Card renewal until HandyPing reminded me. Worth every cent."
            </blockquote>
            <p class="text-sm font-medium text-gray-900">Mick R.</p>
            <p class="text-sm text-gray-600">Electrician, Sydney</p>
          </div>

          <div class="bg-white rounded-lg p-6 shadow-sm">
            <div class="flex mb-4">
              <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" v-for="i in 5" :key="i">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
              </svg>
            </div>
            <blockquote class="text-gray-700 mb-4">
              "I can actually sleep now knowing my insurance and licenses are sorted. Simple to use, does what it says."
            </blockquote>
            <p class="text-sm font-medium text-gray-900">Tony L.</p>
            <p class="text-sm text-gray-600">Landscaper, Brisbane</p>
          </div>

          <div class="bg-white rounded-lg p-6 shadow-sm">
            <div class="flex mb-4">
              <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" v-for="i in 5" :key="i">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
              </svg>
            </div>
            <blockquote class="text-gray-700 mb-4">
              "Saved my bacon with my forklift license. Got the text 30 days out, plenty of time to renew. Legend!"
            </blockquote>
            <p class="text-sm font-medium text-gray-900">Dave M.</p>
            <p class="text-sm text-gray-600">Builder, Melbourne</p>
          </div>
        </div>

        <div class="text-center mt-12">
          <p class="text-gray-600 mb-6">Join thousands of Aussie tradies who never miss a renewal</p>
          <router-link to="/login" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-8 rounded-lg transition duration-200 text-lg">
            Start Your Free Trial
          </router-link>
        </div>
      </div>
    </section>

    <!-- Pricing Section -->
    <section class="py-16 px-4 bg-white">
      <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">
          Simple, honest pricing
        </h2>
        <p class="text-xl text-gray-600 mb-12">
          No tricks, no hidden fees. Just $9 a month after your free trial.
        </p>

        <div class="max-w-sm mx-auto bg-gray-50 rounded-2xl p-8 border-2 border-blue-600">
          <h3 class="text-2xl font-bold text-gray-900 mb-4">HandyPing Pro</h3>
          <div class="mb-6">
            <span class="text-5xl font-bold text-gray-900">$9</span>
            <span class="text-gray-600">/month</span>
          </div>
          
          <ul class="space-y-3 mb-8 text-left">
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
              <span class="text-gray-700">SMS & email notifications</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span class="text-gray-700">30-day free trial</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span class="text-gray-700">Cancel anytime</span>
            </li>
          </ul>

          <router-link to="/login" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
            Get Started Free
          </router-link>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 px-4">
      <div class="max-w-7xl mx-auto text-center">
        <h3 class="text-2xl font-bold mb-2">HandyPing</h3>
        <p class="text-gray-400 mb-8">Built by tradies, for tradies.</p>
        
        <div class="flex justify-center space-x-6 text-sm text-gray-400">
          <a href="#" class="hover:text-white">Privacy</a>
          <a href="#" class="hover:text-white">Terms</a>
          <a href="mailto:support@handyping.com.au" class="hover:text-white">Contact</a>
        </div>
        
        <p class="mt-8 text-sm text-gray-500">
          © 2024 HandyPing. Made with ❤️ in Australia.
        </p>
      </div>
    </footer>
  </div>
</template>

<script>
export default {
  name: 'Landing',
  mounted() {
    // Ensure we're at the top of the page when landing page loads
    window.scrollTo(0, 0);
  }
};
</script> 