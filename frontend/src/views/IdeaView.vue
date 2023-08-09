<template>
  <div>
    <p class="font-bold">Viewing comments for Idea ID: {{ idea.title }}</p>
    <p>Comments Count: {{ idea.content }}</p>
  </div>
  <br>
  <p>Comments: </p>
  <div v-for="comment in idea.comments" >
    <hr>
      <p>{{ comment.content }}</p>
      <p class="">Posted by: {{ comment.user_id }}</p>
      <hr><br>
    </div>
</template>

<script>
export default {
  data() {
    return {
      idea: []
    };
  },
  created() {
    this.fetchIdea();
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
    }
  }
};
</script>

  