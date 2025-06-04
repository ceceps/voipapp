<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Contacts</h1>
    <div class="flex gap-4 mb-4 items-center">
      <input v-model="filters.company" class="border px-3 py-2 rounded w-1/2" placeholder="Search company" />
      <select v-model="filters.role" class="border px-3 py-2 rounded">
        <option value="">All Roles</option>
        <option value="Manager">Manager</option>
        <option value="Employee">Employee</option>
      </select>
      <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" @click="applyFilter">Filter</button>
      <button class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600" @click="resetFilter">Reset</button>
    </div>

    <div v-if="loading" class="text-gray-500 text-sm mb-4 w-1/2">Loading contacts...</div>

    <table class="w-full border-collapse" v-if="!loading">
      <thead>
        <tr class="bg-gray-100">
          <th class="border px-4 py-2">Name</th>
          <th class="border px-4 py-2">Phone</th>
          <th class="border px-4 py-2">Company</th>
          <th class="border px-4 py-2">Role</th>
          <th class="border px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="contact in paginatedContacts" :key="contact.id">
          <td class="border px-4 py-1">{{ contact.name }}</td>
          <td class="border px-4 py-1">{{ contact.phone }}</td>
          <td class="border px-4 py-1">{{ contact.company }}</td>
          <td class="border px-4 py-1">{{ contact.role }}</td>
          <td class="border px-4 py-1">
            <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600" @click="openCallModal(contact)">Call</button>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="mt-4 flex justify-center items-center gap-4" v-if="!loading && totalPages > 1">
      <button :disabled="currentPage === 1" @click="currentPage--" class="px-3 py-1 border rounded bg-gray-100 hover:bg-gray-200">Prev</button>
      <span class="text-sm">Page {{ currentPage }} of {{ totalPages }}</span>
      <button :disabled="currentPage === totalPages" @click="currentPage++" class="px-3 py-1 border rounded bg-gray-100 hover:bg-gray-200">Next</button>
    </div>

    <!-- Call Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg text-center relative">
        <div class="text-4xl text-blue-600 mb-4">
          <i class="fas fa-user-circle"></i>
        </div>
        <h2 class="text-lg font-semibold">Calling {{ selectedContact.name }}</h2>
        <p class="text-gray-600">{{ selectedContact.phone }}</p>
        <p v-if="callStatus" class="mt-2 text-green-600 font-semibold">{{ callStatus }}</p>
        <button @click="closeCallModal" class="mt-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
          <i class="fas fa-phone-slash mr-2"></i> End Call
        </button>
        <button @click="closeCallModal" class="absolute top-2 right-3 text-gray-400 hover:text-gray-600">
          <i class="fas fa-times"></i>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { API_URL } from '@/config';

export default {
  data() {
    return {
      contacts: [],
      filters: {
        company: this.$route.query.company || '',
        role: this.$route.query.role || ''
      },
      loading: false,
      currentPage: 1,
      perPage: 10,
      showModal: false,
      selectedContact: {}
    };
  },
  computed: {
    paginatedContacts() {
      const start = (this.currentPage - 1) * this.perPage;
      return this.contacts.slice(start, start + this.perPage);
    },
    totalPages() {
      return Math.ceil(this.contacts.length / this.perPage);
    }
  },
  mounted() {
    this.fetchContacts();
  },
  methods: {
    applyFilter() {
      const current = this.$route.query;
      if (current.company !== this.filters.company || current.role !== this.filters.role) {
        this.$router.push({
          path: '/contacts',
          query: { ...this.filters }
        });
      }
    },
    resetFilter() {
      this.filters.company = '';
      this.filters.role = '';
      this.currentPage = 1;
      this.$router.push({ path: '/contacts' });
    },
    openCallModal(contact) {
      this.selectedContact = contact;
      this.showModal = true;
      this.callStatus = 'Calling...';
      this.confirmSimulateCall();
    },
    closeCallModal() {
      this.showModal = false;
      this.selectedContact = {};
      this.callStatus = '';
    },
    confirmSimulateCall() {
      axios.post(`${API_URL}/simulate-call/${this.selectedContact.id}`).then(() => {
        this.callStatus = 'Call Ended';
        this.closeCallModal();
        
      });
    },
    fetchContacts() {
      this.loading = true;
      axios.get(`${API_URL}/contacts`, { params: this.filters }).then(res => {
        this.contacts = res.data.filter(c => c && c.id);
        console.log(this.contacts);
        this.loading = false;
        this.currentPage = 1;
      }).catch(() => {
        this.loading = false;
      });
    }
  },
  watch: {
    '$route.query': {
      immediate: true,
      handler(newQuery) {
        this.filters.company = newQuery.company || '';
        this.filters.role = newQuery.role || '';
        this.fetchContacts();
      }
    }
  }
};
</script>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
</style>
