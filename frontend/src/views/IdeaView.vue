<template>
  <div class="my-8 flex justify-center items-center">
    <div  class="border rounded-lg lg:w-3/4 p-4 bg-white">
      <!-- display post -->
    <div>
      <p class="font-semibold text-2xl p-2">{{ idea.title }}</p>
      <p class="text-zinc-400 pb-2 px-2">Posted by: {{ idea.user.name }} at {{ formatTime(idea.created_at) }}</p>
      <p class="px-2">Comments Count: {{ idea.content }}</p>
    </div>
      <br>
      <!-- Comment Submission -->
      <div v-if="user.isAuthenticated">
        <form action="" @submit.prevent="postComment">
        <label for="" class="text-zinc-400">Post a comment (must be within 200 characters):</label><br>
        <textarea v-model="content" name="" id="" cols="60" rows="5" spellcheck="false"
            class="w-full p-2 border border-gray-300 text-stone-600  rounded-md focus:bg-stone-100 focus:outline-none focus:border-emerald-500 hover:bg-stone-100" ></textarea><br>
            <p v-if="content.length > 200" class="text-red-500">Comments cannot exceed 200 characters.</p>
        <button class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 my-4 px-4 rounded" :disabled="content.length > 200">Submit Comment</button> 
      </form>  
      </div>
      <!-- display comments -->
      <p class="text-zinc-400 py-2">Comments: </p>
      <div v-for="comment in idea.comments" >
        <hr>
        <p>{{ comment.content }}</p>
        <p class="text-emerald-500">Posted by: {{ comment.user.name }} at {{ formatTime(idea.created_at) }}</p>
        <hr><br>
      </div>
    </div>
  </div>
</template>

<script>
import { useUserStore } from '@/store/userStore';
import moment from 'moment';
export default {
  data() {
    return {
      idea: [],
      content: '',
    };
  },
  created() {
    this.fetchIdea();
  },
  computed: {
  user() {
    return useUserStore();
    },
  },
  methods: {
    formatTime(time) {
      return moment(time).format('YYYY-MM-DD h:mm A');
    },
    //fetching ideat with comments
    async fetchIdea() {
      try {
        const ideaId = this.$route.params.id;
        const response = await fetch(`http://127.0.0.1:8000/api/ideas/${ideaId}/comments`);
        const data = await response.json();
        this.idea = data;
      } catch (error) {
        console.error('Error fetching idea:', error);
      }
    },
    postComment() { 
      const token = this.user.authToken;
      const userId = this.user.getUserId;
      console.log(userId);

      if (token) {
        
        const comment = {
          content: this.content,
          user_id: userId,
          idea_id: this.$route.params.id,
        };
        fetch('http://127.0.0.1:8000/api/comments', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          },
          body: JSON.stringify(comment),
        })
        .then((response) => {
          if (!response.ok) {
            throw new Error('Error posting comment');
          }
          return response.json();
        })
        
        .then((data) => {
          //adjust data array
          const userInfo = {
            userId: this.user.getUserId,
            userName: this.user.getUserName,
          };
          const commentWithUser = { ...data, user: userInfo };
          this.idea.comments.push(commentWithUser);
          console.log(this.idea);
          
          this.content = '';
        })
        .catch((error) => {
          console.error(error);
        });
      } else {
        console.error('No token');
      }
    },
  }
};
</script>

  