<template>
  <div  class="m-4">
    <!-- display post -->
  <div>
    <p class="font-bold text-xl">{{ idea.title }}</p>
    <p>Posted by: {{ idea.user.name }} at {{ idea.created_at }}</p>
    <p>Comments Count: {{ idea.content }}</p>
    <p class="text-emerald-500">Likes: {{ idea.likes }}</p>
  </div>
    <br>
    <!-- Comment Submission -->
    <div v-if="user.isAuthenticated">
      <form action="" @submit.prevent="postComment">
      <label for="">Post a comment:</label><br>
      <textarea v-model="content" name="" id="" cols="60" rows="5" class="bg-gray-50 rounded-lg border border-gray-300 "></textarea>
      <button>Submit Comment</button> 
    </form>  
    </div>
    <!-- display comments -->
    <p>Comments: {{ user.getUserId }}</p>
    <div v-for="comment in idea.comments" >
      <hr>
      <p>{{ comment.content }}</p>
      <p class="text-emerald-500">Posted by: {{ comment.user.name }} at {{ comment.created_at }}</p>
      <hr><br>
    </div>
  </div>
</template>

<script>
import { useUserStore } from '@/store/userStore';
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
        .then(() => {
          console.log('Comment posted');
          this.$router.push('/');
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

  