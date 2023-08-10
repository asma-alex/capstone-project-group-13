<template>
    <header>
      <div class="wrapper">
        <nav class="shadow-md px-44 py-8">
          <div class="container mx-auto flex justify-between items-center">
            <RouterLink to="/">logologologologolo</RouterLink>            
            <div>
              <!-- Not signed in -->
              <div v-if="!user.isAuthenticated">
                <RouterLink to="/register">Register </RouterLink>
                <RouterLink  to="/login" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded"> Login</RouterLink>
              </div>
              <!-- Signed in -->
              <div v-if="user.isAuthenticated">
                <RouterLink to="/profile">{{ user.getUserName }}</RouterLink>
                <RouterLink to="/create" >Post an Idea</RouterLink>
                <button @click="logout" >Logout</button>
              </div>
              

            </div>
            
          </div>
        </nav>
      </div>
    </header>
  </template>
  
  <script>
import { RouterLink } from 'vue-router';
import { useUserStore } from '@/store/userStore';
export default {
  components: {
    RouterLink
  },
  data() {
    return {
    };
  },
  computed: {
  user() {
    return useUserStore();
    },
  },
  methods: {
    checkLoggedIn() {
      const token = localStorage.getItem('token');
      this.isLoggedIn = token !== null && token !== undefined;
    },
    logout() {
      const userStore = useUserStore();
      localStorage.removeItem('token');
      userStore.clearAuthToken()
      console.log('Logged out');
      this.$router.push('/');

    }
  }
};
</script>
