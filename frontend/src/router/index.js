import Vue from 'vue'
import VueRouter  from 'vue-router'
import LoginsPage from '@/pages/LoginsPage.vue'
import ContactsPage from '@/pages/ContactsPage.vue'
import CallLogsPage from '@/pages/CallLogsPage.vue'

Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'history', // optional, removes # in URL
  routes: [
    {
      path: '/',
      name: 'logins',
      component: LoginsPage
    },
    {
      path: '/contacts',
      name: 'contacts',
      component: ContactsPage
    },
    {
      path: '/call-logs',
      name: 'call-logs',
      component: CallLogsPage
    }
  ]
});

export default router