<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
      <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
      <form @submit.prevent="handleLogin">
        <div class="mb-4">
          <label class="block mb-1 text-gray-600">Email</label>
          <input v-model="email" type="email" class="w-full px-4 py-2 border rounded-md" required>
        </div>
        <div class="mb-6">
          <label class="block mb-1 text-gray-600">Password</label>
          <input v-model="password" type="password" class="w-full px-4 py-2 border rounded-md" required>
        </div>
        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Login</button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import {  API_VER_URL } from "@/config";

//axios.defaults.withCredentials = true;
//axios.defaults.withXSRFToken = true

export default {
  data() {
    return {
      email: '',
      password: '',
      error: ''
    };
  },
  methods: {
    async handleLogin() {
      this.error = '';

      if (!this.email || !this.password) {
        this.error = 'Email and password are required.';
        return;
      }


      try {
        // Require call this first for CSRF Token\
        await axios.get(`/sanctum/csrf-cookie`);

        // continue login
        const res = await axios.post(
          `${API_VER_URL}/login`,
          {
            email: this.email,
            password: this.password
          }
        );

        localStorage.setItem('token', res.data.token);

        this.$router.push('/contacts');
      } catch (err) {
        this.error = err.response?.data?.message || 'Login failed. Please try again.';
      }
    }
  }
};
</script>
<style scoped>
body {
  font-family: 'Inter', sans-serif;
}
</style>