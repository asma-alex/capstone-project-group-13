<template>
    <p>hi</p>
    <div>
        <p>picture</p>
        <p>example_user</p>
        <p>email@email.com</p>
    </div>
    <div>
        <br>
        <p class="font-bold">Your posts:</p>
        <div>
        <div v-for="idea in ideas" :key="idea.id" class="my-8">
            <hr>
          <p class="font-bold">{{ idea.title }}</p>
          <p>{{ idea.content }}</p>
          <p>Likes {{ idea.likes }}</p>
          <router-link :to="'/idea/' + idea.id" class="text-emerald-500 hover:text-emerald-200">View Comments ({{ idea.comments_count }})</router-link>
          <button></button>
          <hr />
        </div>
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
        fetch('http://127.0.0.1:8000/api/ideas/user/1')
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