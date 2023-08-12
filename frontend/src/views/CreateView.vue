<template>
    <div class="my-8 flex justify-center items-center">
        <div class="border rounded-lg lg:w-2/4 p-4 bg-white">
          <form action="" @submit.prevent="createIdea">
            <p class="font-semibold text-2xl p-2">Post a New Idea  </p>
            <p class="p-2 text-zinc-400">Youre idea will be posted on the bulletn board for the whole world to see! You can edit or delete any of your posts at any time by viewing them in your profile.</p>
            <label for="title" class="">Add a title to your post (maximum 100 characters):</label><br>
            <input type="text" v-model="title" name="title" class="h-10 p-2 w-full border text-stone-600 border-gray-300 rounded-md focus:outline-none focus:border-emerald-500 hover:bg-stone-100 focus:bg-stone-100">
            <p v-if="title.length > 100" class="text-red-500">Comments cannot exceed 100 characters.</p><br>
            <input type="hidden" >
            <label for="" class="">Post content (maximum 500 characters):</label><br>
            <textarea v-model="content" name="" id="" cols="30" rows="10" spellcheck="false"
            class="w-full p-2 border border-gray-300 text-stone-600  rounded-md focus:bg-stone-100 focus:outline-none focus:border-emerald-500 hover:bg-stone-100" ></textarea><br>
            <p v-if="content.length > 500" class="text-red-500">Comments cannot exceed 500 characters.</p><br>
            <button type="submit" class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded" :disabled="content.length > 500 || title.length > 100">Share Your Idea</button>
        </form>
      </div>
    
</div>
</template>

<script>
//get id
import { useUserStore } from '@/store/userStore';
export default {
  data() {
    return {
      title: '',
      content: '',

    };
  },
  computed: {
  user() {
    return useUserStore();
    },
  },
  methods: {
    createIdea() {
      //const token = localStorage.getItem('token'); 
      const token = this.user.authToken;
      const userId = this.user.getUserId;
      if (token) {
        const idea = {
          title: this.title,
          content: this.content,
          user_id: userId,
        };
        fetch('http://127.0.0.1:8000/api/ideas', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          },
          body: JSON.stringify(idea),
        })
        .then((response) => {
          if (!response.ok) {
            throw new Error('Error');
          }
          return response.json();
        })
        .then(() => {
          console.log('Idea posted');
          this.$router.push('/');
        })
        .catch((error) => {
          console.error(error);
        });
      } else {
        console.error('No token');
      }
    },
  },
};

</script>