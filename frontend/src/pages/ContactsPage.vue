<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Contacts</h1>
    <div class="flex gap-4 mb-4">
      <input
        v-model="filters.company"
        class="border px-3 py-2 rounded w-1/2"
        placeholder="Search company"
      />
      <select
        v-model="filters.role"
        class="border px-3 py-2 rounded"
      >
        <option value="">All Roles</option>
        <option value="manager">Manager</option>
        <option value="employee">Employee</option>
      </select>
       <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" @click="applyFilter">Filter</button>
    </div>
    <table class="w-full border-collapse">
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
        <tr v-for="contact in contacts" :key="contact.id">
          <td class="border px-4 py-2">{{ contact.name }}</td>
          <td class="border px-4 py-2">{{ contact.phone }}</td>
          <td class="border px-4 py-2">{{ contact.company }}</td>
          <td class="border px-4 py-2">{{ contact.role }}</td>
          <td class="border px-4 py-2">
            <button
              class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600"
              @click="simulateCall(contact.id)"
            >
              Call
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from "axios";
import { API_URL } from "@/config";

export default {
  data() {
    return {
      contacts: [],
      errors: [],
      filters: {
        company: this.$route.query.company || "",
        role: this.$route.query.role || "",
      },
    };
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
  methods: {
    applyFilter() {
      const current = this.$route.query;
      if (
        current.company !== this.filters.company ||
        current.role !== this.filters.role
      ) {
        this.$router.push({
          path: "/contacts",
          query: { ...this.filters },
        });
      }
    },
    simulateCall(id) {
      axios
        .post(`${API_URL}/simulate-call/${id}`)
        .then(() => alert("Call simulated"))
        .catch((e) => {
          this.errors.push(e);
        });
    },
    fetchContacts() {
      axios
        .get(`${API_URL}/contacts`, { params: this.filters })
        .then((res) => {
          console.log(res);
          this.contacts = res.data.data.filter((c) => c && c.id);
        })
        .catch((e) => {
          this.errors.push(e);
        });
    },
  },
};
</script>
