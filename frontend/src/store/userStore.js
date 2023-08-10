import { defineStore } from 'pinia';

export const useUserStore = defineStore('user', {
  state: () => ({
    authToken: null,
    userId: null,
    userName: null,
  }),
  getters: {
    isAuthenticated: (state) => state.authToken !== null,
    getUserId: (state) => state.userId,
    getUserName: (state) => state.userName,
    getAuthToken: (state) => state.authToken
  },
  actions: {
    setAuthToken(token) {
      this.authToken = token;
    },
    setUser(data) {
        this.userId = data.id;
        this.userName = data.name;
      },
    clearAuthToken() {
        this.authToken = null;
        this.userId = null;
        this.userName = null;
    },
  },
});