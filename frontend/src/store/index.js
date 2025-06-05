import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";
import { API_URL } from "@/config";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    contacts: [],
    callLogs: [],
    favorites: [],
    statuses: [],
  },
  mutations: {
    setContacts(state, contacts) {
      state.contacts = contacts.map((contact) => ({
        ...contact,
        isFavorite: false, // default
      }));
    },
    toggleFavorite(state, contactId) {
      const contact = state.contacts.find((c) => c.id === contactId);
      if (contact) {
        contact.isFavorite = !contact.isFavorite;
      }
    },
    setCallLogs(state, logs) {
      state.callLogs = logs;
      state.statuses = [...new Set(logs.map((log) => log.status))]; // Unique status
    },
  },
  actions: {
    async fetchContacts({ commit }, filters = {}) {
      const response = await axios.get(API_URL + "/contacts", {
        params: filters,
      });
      commit("setContacts", response.data.data);
    },
    async fetchCallLogs({ commit }, filters = {}) {
      const response = await axios.get(API_URL + "/call-logs", {
        params: filters,
      });
      commit("setCallLogs", response.data);
    },
  },
  getters: {
    getFavorites(state) {
      return state.favorites;
    },
    getStatuses(state) {
      return state.statuses;
    },
    getContacts(state) {
      return state.contacts;
    },
    getCallLogs(state) {
      return state.callLogs;
    },
  },
});
