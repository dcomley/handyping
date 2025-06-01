import './bootstrap';
import { createApp } from 'vue';
import router from './router';
import App from './App.vue';

// Create Vue app
const app = createApp(App);

// Use router
app.use(router);

// Mount app
app.mount('#app'); 