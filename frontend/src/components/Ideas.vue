<template>
    <div>
      <p class="font-bold text-xl">Bulletin board:</p>
        <div v-for="idea in ideas" :key="idea.id" class="my-8">
            <hr>
          <p class="font-bold text-xl">{{ idea.title }}</p>
          <p class="text-zinc-400">Posted by: {{ idea.user.name }} at {{ idea.created_at }}</p>
          <p>{{ idea.content }}</p>
          <p class="text-emerald-500">Likes {{ idea.likes }}</p>
          <router-link :to="'/idea/' + idea.id" class="text-emerald-500 hover:text-emerald-200">View Comments ({{ idea.comments_count }})</router-link>
          <hr />
        </div>
      </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        ideas: [], 
       
      };
    },
    mounted() {
      this.fetchIdeas();
    },
    methods: {
      fetchIdeas() {
        //api fetch request
        fetch('http://127.0.0.1:8000/api/ideas')
          .then(response => {
            if (!response.ok) {
              throw new Error('Could not fetch');
            }
            return response.json();
          })
          .then(data => {
            //store ideas in data array
            this.ideas = data;
            this.home = true;
          })
          .catch(error => {
            console.error('Could not fetch ideas:', error); 
          });
      }
    }
  };
  </script>
  