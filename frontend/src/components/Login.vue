
<template>
    <div class="flex justify-center my-32">
        
        <div class="max-w-md bg-white p-8 shadow-md rounded-md">
            <h2 class="text-3xl font-bold mb-2">Sign In to Your Account</h2>
            <RouterLink to="/register" class="hover:text-emerald-500">Don't have an account? </RouterLink>
            <form @submit.prevent="login" class="mt-4">
                <div class="mb-2 text-left">
                    <label for="email" class="block text-gray-600 font-medium mb-1">Email:</label>
                    <input id="email" v-model="email" type="email" name="" class="h-10 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500">
                </div>
                <div v-if="emailError" class="text-red-500">{{ emailError }}</div>
                <div class="mb-2 text-left">
                    <label for="password" class="block text-gray-600 font-medium mb-1">Password:</label>
                    <input id="password" v-model="password" type="password" name="" class="h-10 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500">
                </div>
                <div v-if="passwordError" class="text-red-500">{{ passwordError }}</div>
                <div v-if="errorMessage" class="text-red-500">{{ errorMessage }}</div>
                
                    <button type="submit" class="w-full px-4 py-2 my-2 bg-emerald-500 text-white rounded-md hover:bg-emerald-600 focus:outline-none focus:bg-emerald-600">Sign In</button>
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
      //for server side error
      errorMessage: '',
      //client side
      emailError: '',
      passwordError: '',
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
      //front end validation
      this.emailError = this.email === '' ? 'Email is required' : '';
      this.passwordError = this.password === '' ? 'Password is required' : '';

      if (this.email === '' || this.password === '') {
        return; 
      }
      //appi fetch
      fetch('http://127.0.0.1:8000/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify(userInfo),
      })
        .then((response) => {
          // check for an error
          if (!response.ok) {
            return response.json().then((errorData) => {
              throw new Error(errorData.message);
            });
          }
          console.log(response)
          return response.json();
        })
        .then((data) => {
          //set data in store
          const userStore = useUserStore();
          userStore.setAuthToken(data.token);
          userStore.setUser(data.user)

          console.log('token set',userStore.getAuthToken, userStore.getUserId, userStore.getUserEmail);
          this.$router.push('/');

        })
        //set the error message in data from the api response
        .catch((error) => {
          this.errorMessage = error.message;
        });
    },
  },
};

</script>