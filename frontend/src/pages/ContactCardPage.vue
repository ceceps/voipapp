<template>
  <div class="p-6 bg-slate-400 min-h-200">
    <h1 class="text-2xl font-bold mb-6">Contacts | Call Logs </h1>
    
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
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
      <div
        v-for="contact in paginatedContacts"
        :key="contact.id"
        class="bg-white p-4 rounded-lg shadow relative"
      >
        <div class="absolute top-3 right-3 w-10 h-10 rounded-full overflow-hidden border">
          <img alt="{{ contact.name }}"
            :src="contact.avatar || 'https://i.pravatar.cc/100?u=' + contact.id"
            class="w-full h-full object-cover"
          />
        </div>

        <h3 class="text-lg font-semibold">{{ contact.name }}</h3>
        <span
          class="inline-block text-xs font-semibold text-green-700 bg-green-100 rounded px-2 py-0.5 mb-1"
          >{{ contact.role }}</span
        >
        <p class="text-gray-500 text-sm">
        Company: {{ contact.company }} <br>
        Phone: {{ contact.phone }}</p>

        <div class="mt-4 flex divide-x border-t pt-3">
         <button
            @click="toggle(contact.id)"
            :class="contact.isFavorite ? 'text-orange-500' : 'text-gray-700'"
             class="flex-1 text-center text-sm text-gray-700 hover:text-orange-500"
          >
            <i class="fas fa-star mr-1 "></i>Favorite
          </button>
          <button
            class="flex-1 text-center text-sm text-red-600 hover:text-orange-500"
            @click="openCallModal(contact)"
          >
            <i class="fas fa-phone mr-1"></i>Call
          </button>
        </div>
      </div>
    </div>
    <!-- pagination -->
     <div class="mt-4 flex justify-center items-center gap-4" v-if="!loading && totalPages > 1">
      <button :disabled="currentPage === 1" @click="currentPage--" class="px-3 py-1 border rounded bg-gray-100 hover:bg-gray-200">Prev</button>
      <span class="text-sm">Page {{ currentPage }} of {{ totalPages }}</span>
      <button :disabled="currentPage === totalPages" @click="currentPage++" class="px-3 py-1 border rounded bg-gray-100 hover:bg-gray-200">Next</button>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg text-center relative">
        <div class="text-4xl text-blue-600 mb-4">
          <i class="fas fa-user-circle"></i>
        </div>
        <h2 class="text-lg font-semibold">{{ selectedContact.name }}</h2>
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
import axios from "axios";
import { API_URL } from "@/config";

export default {
  data() {
    return {
      contacts: [],
      filters: {
        company: this.$route.query.company || "",
        role: this.$route.query.role || "",
      },
      loading: false,
      currentPage: 1,
      perPage: 9,
      showModal: false,
      selectedContact: {},
      callStatus : String,
    };
  },
  computed: {
    paginatedContacts() {
      const start = (this.currentPage - 1) * this.perPage;
      return this.contacts.slice(start, start + this.perPage);
    },
    totalPages() {
      return Math.ceil(this.contacts.length / this.perPage);
    },
  },
  mounted() {
    this.fetchContacts();
  },
  methods: {
    applyFilter() {
      const current = this.$route.query;
      if (
        current.company !== this.filters.company ||
        current.role !== this.filters.role
      ) {
        this.$router.push({
          path: "/contact-lists",
          query: { ...this.filters },
        });
      }
    },
    resetFilter() {
      this.filters.company = "";
      this.filters.role = "";
      this.currentPage = 1;
      this.$router.push({ path: "/contact-lists" });
    },
    openCallModal(contact) {
      this.selectedContact = contact;
      this.showModal = true;
      this.callStatus = "Calling...";
      this.confirmSimulateCall();
    },
    closeCallModal() {
      this.showModal = false;
      this.selectedContact = {};
      this.callStatus = "";
    },
    confirmSimulateCall() {
      axios.post(`${API_URL}/simulate-call/${this.selectedContact.id}`)
        .then((res) => {
        console.log(res.data.data.status);
        this.callStatus = res.data.data.status;
        this.closeCallModal();
      });
    },
    fetchContacts() {
      this.loading = true;
      axios
        .get(`${API_URL}/contacts`, { params: this.filters })
        .then((res) => {
          this.contacts = res.data.filter((c) => c && c.id);
          this.loading = false;
          this.currentPage = 1;
        })
        .catch(() => {
          this.loading = false;
        });
    },
  },
  watch: {
    "$route.query": {
      immediate: true,
      handler(newQuery) {
        this.filters.company = newQuery.company || "";
        this.filters.role = newQuery.role || "";
        this.fetchContacts();
      },
    },
  },
};
</script>

<style scoped>
@import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css");
</style>
