<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-6">
       <a href="/">Home</a> | <a href="/contacts">Contacts</a> | <a href="/call-logs">Call Logs</a>
    </h1>

    <div class="mb-4 flex flex-wrap gap-4 items-end">
      <input v-model="search" @input="fetchCallLogs" placeholder="Search by contact name" class="border px-3 py-2 rounded w-1/2" />
      <div>
        <label class="block text-sm font-medium text-gray-700">Start Date</label>
        <input type="date" v-model="startDate" format="dd=mm-YYYY" @change="fetchCallLogs" class="border px-3 py-2 rounded" />
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">End Date</label>
        <input type="date" v-model="endDate" @change="fetchCallLogs" class="border px-3 py-2 rounded" />
      </div>
       <div v-if="loading" class="text-gray-500 text-sm mt-4">Loading call logs...</div>
    </div>

    <table class="w-full table-auto border-collapse text-sm rounded">
      <thead class="bg-blue-400">
        <tr>
          <th class="border px-4 py-2 text-left">Contact Name</th>
          <th class="border px-4 py-2 text-left">Duration (sec)</th>
          <th class="border px-4 py-2 text-left">Timestamp</th>
          <th class="border px-4 py-2 text-left">Status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="log in paginatedLogs" :key="log.id" class="bg-yellow-200">
          <td class="border px-4 py-2">{{ log.contact?.name || '-' }}</td>
          <td class="border px-4 py-2">{{ log.duration }}</td>
          <td class="border px-4 py-2">{{ formatTimestamp(log.created_at) }}</td>
          <td class="border px-4 py-2">{{ log.status }}</td>
        </tr>
      </tbody>
    </table>

    <div class="mt-4 flex justify-center items-center gap-4" v-if="totalPages > 1">
      <button :disabled="currentPage === 1" @click="currentPage--" class="px-3 py-1 border rounded bg-gray-100 hover:bg-gray-200">Prev</button>
      <span class="text-sm">Page {{ currentPage }} of {{ totalPages }}</span>
      <button :disabled="currentPage === totalPages" @click="currentPage++" class="px-3 py-1 border rounded bg-gray-100 hover:bg-gray-200">Next</button>
    </div>

   
  </div>
</template>

<script>
import axios from 'axios';
import { API_VER_URL } from '@/config';

export default {
  data() {
    return {
      logs: [],
      loading: false,
      search: '',
      startDate: '',
      endDate: '',
      currentPage: 1,
      perPage: 10
    };
  },
  computed: {
    filteredLogs() {
      return this.logs.filter(log => {
        const nameMatch = log.contact?.name?.toLowerCase().includes(this.search.trim().toLowerCase());
        return nameMatch;
      });
    },
    totalPages() {
      return Math.ceil(this.filteredLogs.length / this.perPage);
    },
    paginatedLogs() {
      const start = (this.currentPage - 1) * this.perPage;
      return this.filteredLogs.slice(start, start + this.perPage);
    }
  },
  methods: {
    fetchCallLogs() {
      this.loading = true;
      axios.get(`${API_VER_URL}/call-logs`, {
        params: {
          start_date: this.startDate,
          end_date: this.endDate,
          search: this.search
        }
      })
      .then(res => {
        const data = res.data.data;
        this.logs = Array.isArray(data) ? data : [data];
        this.currentPage = 1;
      })
      .finally(() => {
        this.loading = false;
      });
    },
    formatTimestamp(datetime) {
      if (!datetime) return '-';
      const date = new Date(datetime);
      return date.toLocaleString('en-US', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
      });
    }
  },
  mounted() {
    this.fetchCallLogs();
  }
};
</script>

<style scoped>
table th, table td {
  white-space: nowrap;
}
</style>
