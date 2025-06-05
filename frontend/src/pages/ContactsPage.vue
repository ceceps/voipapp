<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-6 active:text-blue">
      <a href="/contacts">Contacts</a> | <a href="/call-logs">Call Logs</a>
    </h1>
    <div class="flex gap-4 mb-4 items-center">
      <input
        v-model="filters.company"
        class="border px-3 py-2 rounded w-1/2"
        placeholder="Search company"
      />
      <select v-model="filters.role" class="border px-3 py-2 rounded">
        <option value="">All Roles</option>
        <option value="Manager">Manager</option>
        <option value="Employee">Employee</option>
      </select>
      <button
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        @click="applyFilter"
      >
        Filter
      </button>
      <button
        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
        @click="resetFilter"
      >
        Reset
      </button>
      <div v-if="loading" class="text-gray-500 text-sm mb-4">Loading contacts...</div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6" v-if="!loading">
      <div
        v-for="contact in paginatedContacts"
        :key="contact.id"
        class="bg-white p-4 rounded-lg shadow relative"
      >
        <div class="absolute top-3 right-3 w-10 h-10 rounded-full overflow-hidden border">
          <img
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
          {{ contact.company }} <br />
          {{ contact.phone }}
        </p>

        <div class="mt-4 flex divide-x border-t pt-3">
          <button class="flex-1 text-center text-sm text-gray-700 hover:text-yellow-600">
            <i class="fas fa-notes mr-1"></i>Notes
          </button>
          <button
            @click="toggle(contact.id)"
            :class="contact.isFavorite ? 'text-yellow-500' : 'text-gray-400'"
            class="flex-1 text-center text-sm text-gray-700 hover:text-yellow-600"
          >
            <i class="fas fa-star mr-1"></i>Favorite
          </button>
          <button
            class="flex-1 text-center text-sm text-gray-700 hover:text-red-600"
            @click="openCallModal(contact)"
          >
            <i class="fas fa-phone mr-1"></i>Call
          </button>
        </div>
      </div>
    </div>

    <div
      class="mt-4 flex justify-center items-center gap-4"
      v-if="!loading && totalPages > 1"
    >
      <button
        :disabled="currentPage === 1"
        @click="currentPage--"
        class="px-3 py-1 border rounded bg-gray-100 hover:bg-gray-200"
      >
        Prev
      </button>
      <span class="text-sm">Page {{ currentPage }} of {{ totalPages }}</span>
      <button
        :disabled="currentPage === totalPages"
        @click="currentPage++"
        class="px-3 py-1 border rounded bg-gray-100 hover:bg-gray-200"
      >
        Next
      </button>
    </div>

    <!-- Call Modal -->
    <transition name="fade">
      <div
        v-if="showModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
      >
        <div
          class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg text-center relative"
        >
          <div class="flex text-4xl text-blue-600 mb-4 items-center justify-center">
            <img
              :src="
                selectedContact.avatar ||
                'https://i.pravatar.cc/100?u=' + selectedContact.id
              "
              class="w-10 h-10  rounded-full align-middle"
            />
          </div>
          <h2 class="text-lg font-semibold"> {{ selectedContact.name }}</h2>
          <p class="text-gray-600">{{ selectedContact.phone }}</p>
          <p v-if="callStatus" class="mt-2 text-green-600 font-semibold">
            {{ callStatus }}
          </p>
          <button
            @click="closeCallModal"
            class="mt-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
          >
            <i class="fas fa-phone-slash mr-2"></i> End Call
          </button>
          <button
            @click="closeCallModal"
            class="absolute top-2 right-3 text-gray-400 hover:text-gray-600"
          >
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import axios from "axios";
import { API_URL } from "@/config";
import { mapState, mapMutations } from "vuex";

export default {
  data() {
    return {
      filters: {
        company: this.$route.query.company || "",
        role: this.$route.query.role || "",
      },
      loading: false,
      currentPage: 1,
      perPage: 6,
      showModal: false,
      selectedContact: {},
      callStatus: "",
    };
  },
  computed: {
    ...mapState(["contacts"]),
    paginatedContacts() {
      const start = (this.currentPage - 1) * this.perPage;
      return this.contacts.slice(start, start + this.perPage);
    },
    totalPages() {
      return Math.ceil(this.contacts.length / this.perPage);
    },
  },
  methods: {
    ...mapMutations(["toggleFavorite", "setContacts"]),
    toggle(contactId) {
      this.toggleFavorite(contactId);
    },
    applyFilter() {
      this.$router.push({
        path: "/contacts",
        query: { ...this.filters },
      });
    },
    resetFilter() {
      this.filters.company = "";
      this.filters.role = "";
      this.currentPage = 1;
      const isAtRoot = Object.keys(this.$route.query).length === 0;
      if (!isAtRoot) {
        this.$router.push({ path: "/contacts" });
      }
    },
    openCallModal(contact) {
      this.selectedContact = contact;
      this.showModal = true;
      this.callStatus = "Calling...";
      this.confirmSimulateCall();
    },
    closeCallModal() {
      setTimeout(() => {
        this.showModal = false;
        this.selectedContact = {};
        this.callStatus = "";
      }, 800);
    },
    confirmSimulateCall() {
      axios.post(`${API_URL}/simulate-call/${this.selectedContact.id}`).then((res) => {
            this.callStatus = res.data.data.status;
            console.log(this.callStatus);
            this.closeCallModal();
        
      });
    },
    fetchContacts() {
      this.loading = true;
      axios
        .get(`${API_URL}/contacts`, { params: this.filters })
        .then((res) => {
          this.setContacts(res.data);
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
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>
