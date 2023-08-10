
<template>
    <div class="flex justify-center my-32">
        
        <div class="max-w-md bg-white p-8 shadow-md rounded-md">
            <h2 class="text-3xl font-bold mb-2">Sign In to Your Account</h2>
            <a href="#" class="text-indigo-600 hover:text-indigo-500">Don't have an account?</a>
            <form @submit.prevent="login" class="mt-4">
                <div class="mb-2 text-left">
                    <label for="email" class="block text-gray-600 font-medium mb-1">Email</label>
                    <input id="email" v-model="email" type="email" name="" class="h-10 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500">
                </div>
                <div class="mb-2 text-left">
                    <label for="password" class="block text-gray-600 font-medium mb-1">Email</label>
                    <input id="password" v-model="password" type="password" name="" class="h-10 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500">
                </div>
                <br>
                    <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-indigo-600">Sign In</button>
            </form>
        </div>
        
    </div>
</template>

<script>
import { useUserStore } from '@/store/userStore';
export default {
  data() {
    return {
      email: '',
      password: '',
    };
  },
  computed: {
    user() {
      return useUserStore();
    },
  },
  methods: {
    login() {
      const userInfo = {
        email: this.email,
        password: this.password,
      };
      console.log(userInfo)
      fetch('http://127.0.0.1:8000/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify(userInfo),
      })
        .then((response) => {
          if (!response.ok) {
            console.log(response);
            throw new Error('Login failed');
          }
          console.log(response)
          return response.json();
        })
        .then((data) => {
          const userStore = useUserStore();
          //set token in the store
          userStore.setAuthToken(data.token);
          //set user in the store
          userStore.setUser(data.user)
        // const token = data.token;
          //localStorage.setItem('token', token);
          console.log('token set',userStore.getAuthToken, userStore.getUserId, userStore.getUserName);
          this.$router.push('/');

        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
};

</script>