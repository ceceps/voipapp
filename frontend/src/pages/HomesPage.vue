<template>
  <div class="bg-white pb-8">
    <div class="p-4 pb-0 bg-third-bg sm:max-w-7xl mx-auto">
     
      <div class="sm:flex sm:max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 sm:items-center sm:justify-center gap-20 bg-white p-6">
        
        <!-- Contacts Card -->
        <div 
          class="grid justify-items-center text-center cursor-pointer transition-transform duration-300 ease-in-out hover:scale-105"
          @click="route('/contacts')"
        >
          <img class="w-32" src="assets/forma4.png"  alt="Contacts" />
          <div class="text-xl font-bold">Contacts</div>
          <div>List of Your Leads</div>
        </div>

        <!-- Call Logs Card -->
        <div 
          class="grid justify-items-center text-center cursor-pointer transition-transform duration-300 ease-in-out hover:scale-105"
          @click="route('/call-logs')" 
        >
          <img class="w-32" src="assets/forma3.png"  alt="Call Logs" />
          <div class="sm:flex text-xl font-bold">Call Logs</div>
          <div class="sm:flex sm:text-center">List of Your Call Logs</div>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    route(path) {
      this.$router.push(path);
    }
  }
}
</script>

<style scoped>
body {
  font-family: "Inter", sans-serif;
}
</style>