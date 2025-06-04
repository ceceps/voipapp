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
export default {
  data() {
    return {
      email: '',
      password: ''
    }
  },
  methods: {
    handleLogin() {
      // Axios login logic here
      alert(`Login with ${this.email}`);
    }
  }
}
</script>