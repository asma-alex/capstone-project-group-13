import { defineStore } from 'pinia';

export const useUserStore = defineStore('user', {
  state: () => ({
    authToken: null,
    userId: null,
    userName: null,
    userEmail: null,
  }),
  getters: {
    isAuthenticated: (state) => state.authToken !== null,
    getUserId: (state) => state.userId,
    getUserName: (state) => state.userName,
    getUserEmail: (state) => state.userEmail,
    getAuthToken: (state) => state.authToken
  },
  actions: {
    setAuthToken(token) {
      this.authToken = token;
    },
    setUser(data) {
        this.userId = data.id;
        this.userName = data.name;
        this.userEmail = data.email;
        
      },
    clearAuthToken() {
        this.authToken = null;
        this.userId = null;
        this.userName = null;
    },
  },
});