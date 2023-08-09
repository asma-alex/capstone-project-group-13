<template>
    <header>
      <div class="wrapper">
        <nav class="shadow-md px-44 py-8">
          <div class="container mx-auto flex justify-between items-center">
            <RouterLink to="/">logologologologolo</RouterLink>
            <RouterLink to="/about">About</RouterLink>
            <RouterLink to="/register">Register</RouterLink>
            <template v-if="!isLoggedIn">
              <RouterLink to="/login">Login</RouterLink>
            </template>
            <template v-else>
              <button @click="logout">Logout</button>
            </template>
          </div>
        </nav>
      </div>
    </header>
  </template>
  
  <script>
  import { RouterLink } from 'vue-router';
  
  export default {
    components: {
      RouterLink
    },
    data() {
      return {
        isLoggedIn: false
      };
    },
    created() {
      // Check if the user is logged in on component creation
      this.checkLoggedIn();
    },
    methods: {
      checkLoggedIn() {
        const token = localStorage.getItem('token');
        this.isLoggedIn = token !== null && token !== undefined;
      },
      logout() {
        localStorage.removeItem('token');
        this.isLoggedIn = false;
      }
    }
  };
  </script>
  