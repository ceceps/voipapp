<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Call Logs</h1>
    <div class="mb-4 flex gap-4">
      <input type="date" v-model="startDate" class="border px-3 py-2 rounded">
      <input type="date" v-model="endDate" class="border px-3 py-2 rounded">
    </div>
    <table class="w-full border-collapse">
      <thead>
        <tr class="bg-gray-100">
          <th class="border px-4 py-2">Contact</th>
          <th class="border px-4 py-2">Timestamp</th>
          <th class="border px-4 py-2">Duration</th>
          <th class="border px-4 py-2">Status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="log in logs" :key="log.id">
          <td class="border px-4 py-2">{{ log.contact.name }}</td>
          <td class="border px-4 py-2">{{ log.timestamp }}</td>
          <td class="border px-4 py-2">{{ log.duration }} sec</td>
          <td class="border px-4 py-2">{{ log.status }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';
import { API_URL } from '@/config';

export default {
  data() {
    return {
      logs: [],
      startDate: '',
      endDate: ''
    };
  },
  methods: {
    fetchLogs() {
      axios.get(`${API_URL}/api/call-logs`, {
        params: {
          start_date: this.startDate,
          end_date: this.endDate
        }
      }).then(res => {
        this.logs = res.data;
      });
    }
  },
  mounted() {
    this.fetchLogs();
  }
};
</script>