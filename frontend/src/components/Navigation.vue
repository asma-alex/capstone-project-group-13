<template>
    <header>
      <div class="wrapper">
        <nav class="shadow-md px-44 py-6 bg-white">
          <div class="container mx-auto flex justify-between items-center">
            <RouterLink to="/"><img src="src/assets/logo.png" class="w-1/2 md:w-1/4 lg:w-1/6"></RouterLink>            
            <div>
              <!-- Not signed in -->
              <div v-if="!user.isAuthenticated">
                <RouterLink to="/register" class="hover:text-emerald-500">Register </RouterLink>
                <RouterLink  to="/login" 
                  class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 px-4 rounded"> Login
                </RouterLink>
              </div>
              <!-- Signed in -->
              <div v-if="user.isAuthenticated"> 
                <div>
                  
                  <RouterLink :to="'/profile/' + user.getUserId " 
                    class="text-emerald-500 text-lg hover:text-emerald-300"><p></p><i class="fa-solid fa-user"></i> @{{ user.getUserName }}
                  </RouterLink>
                  <button @click="logout" class="mx-4">Logout</button>
                </div>
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
      //localStorage.removeItem('token');
      userStore.clearAuthToken()
      console.log('Logged out');
      this.$router.push('/');

    }
  }
};
</script>
