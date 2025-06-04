import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    callLogs: [],
    statuses: [] // Menyimpan hanya daftar status dari log
  },
  mutations: {
    setCallLogs(state, logs) {
      state.callLogs = logs;
      state.statuses = [...new Set(logs.map(log => log.status))]; // Unique status
    }
  },
  actions: {
    async fetchCallLogs({ commit }, filters = {}) {
      const response = await axios.get('/api/call-logs', { params: filters });
      commit('setCallLogs', response.data);
    }
  },
  getters: {
    getStatuses(state) {
      return state.statuses;
    },
    getCallLogs(state) {
      return state.callLogs;
    }
  }
});
