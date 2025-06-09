import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import './assets/tailwind.css'
import axios from 'axios';
import { API_URL } from '@/config';

axios.defaults.withCredentials = false;
// axios.defaults.withXSRFToken = false;
axios.defaults.baseURL =  API_URL;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.config.productionTip = false

Vue.config.devtools = true;
window.Vue = Vue;

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app');
