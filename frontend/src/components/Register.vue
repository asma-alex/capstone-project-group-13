<template>
    <div class="flex justify-center my-12">
        
        <div class="max-w-md bg-white p-8 shadow-md rounded-md">
            <h2 class="text-3xl font-bold mb-2">
                Register for an Account</h2>
            <p></p>
            <form action="" @submit.prevent="register" class="mt-4">
                <!-- name -->
                <div class="mb-2 text-left">
                    <label for="name" 
                        class="block text-gray-600 font-medium mb-1">Name</label>
                    <input v-model="name" id="name" name="" 
                        class="h-10 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:border-emerald-500">
                </div>
                <div v-if="nameError" class="text-red-500">{{ nameError }}</div>
                <!-- email -->
                <div class="mb-2 text-left">
                    <label for="email" 
                        class="block text-gray-600 font-medium mb-1">
                        Email</label>
                    <input v-model="email" id="email" 
                        class="h-10 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:border-emerald-500">
                </div>
                <div v-if="emailError" class="text-red-500">{{ emailError }}</div>

                <!-- pass -->
                <div class="mb-2 text-left">
                    <label for="password" 
                        class="block text-gray-600 font-medium mb-1">
                        Password</label>
                    <input v-model="password" id="password" type="password" name="" 
                        class="h-10 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:border-emerald-500">
                </div>
                <div v-if="passwordError" class="text-red-500">{{ passwordError }}</div>
                <!-- confirm pass -->
                <div class="mb-2 text-left">
                    <label for="password" 
                        class="block text-gray-600 font-medium mb-1">
                        Password</label>
                    <input v-model="password_confirmation" id="password" type="password"
                        class="h-10 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:border-emerald-500">
                </div>
                <div v-if="passwordConfirmError" class="text-red-500">{{ passwordConfirmError }}</div>
                <div v-if="errorMessage" class="text-red-500">{{ errorMessage }}</div>
                    <button type="submit" 
                        class="w-full px-4 py-2 my-2 bg-emerald-500 text-white rounded-md hover:bg-emerald-700 focus:outline-none focus:bg-emerald-600">
                        Register</button>
            </form>
        </div>
        
    </div>
    
</template>

<script>
import { useUserStore } from '@/store/userStore';
export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      errorMessage: '',
      nameError: '',
      emailError: '',
      passwordError: '',
      passwordConfirmError: '',
    };
  },
  computed: {
    user() {
      return useUserStore();
    },
  },
  methods: {
    register() {
      const userInfo = {
        name: this.name,
        email: this.email,
        password: this.password,
        password_confirmation: this.password_confirmation,
      };
      this.emailError = this.email === '' ? 'Email is required' : '';
      this.passwordError = this.password === '' ? 'Password is required' : '';
      this.nameError = this.name === '' ? 'Name is required' : '';
      this.passwordConfirmError = this.password_confirmation === '' ? 'Password confirmation is required' : '';

      if (this.email === '' || this.password === '' || this.name === '' || this.password_confirmation === '') {
        return;
      }

      console.log(userInfo)
      fetch('http://127.0.0.1:8000/register', {
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
          this.signIn(userInfo);
          //console.log(response)
          return response.json();
          
    // Registration successful, call the sign-in method
          
      })
      .catch((error) => {
          //console.log(error.message)
          if (error instanceof SyntaxError && error.message.includes('JSON')) {
            this.errorMessage = "";
          } else {
            //set error message
            this.errorMessage = error.message;
          }
        }); 
        //sign in registered user

        // fetch('http://127.0.0.1:8000/login', {
        // method: 'POST',
        // headers: {
        //   'Content-Type': 'application/json',
        //   'Accept': 'application/json'
        // },
        // body: JSON.stringify(userInfo),
        // }) 
        // .then((response) => {  
        //   return response.json()
        // })
        // .then((data) => {
        //     //set data in store
        //     const userStore = useUserStore();
        //     userStore.setAuthToken(data.token);
        //     userStore.setUser(data.user)

        //     console.log('token set',userStore.getAuthToken, userStore.getUserId, userStore.getUserName);
        //     this.$router.push('/');

        //   })    
    },
    signIn(userInfo){
      console.log('signing in');
      console.log(userInfo, 'this is sign in user info')
      fetch('http://127.0.0.1:8000/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify(userInfo),
        }) 
        .then((response) => {  
          return response.json()
        })
        .then((data) => {
            //set data in store
            const userStore = useUserStore();
            userStore.setAuthToken(data.token);
            userStore.setUser(data.user)

            console.log('token set',userStore.getAuthToken, userStore.getUserId, userStore.getUserName);
            this.$router.push('/');

          })
    }
  },
};

</script>