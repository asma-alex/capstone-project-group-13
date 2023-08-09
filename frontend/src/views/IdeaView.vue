<template>
  <div  class="m-4">
  <div>
    <p class="font-bold">{{ idea.title }}</p>
    <p>Posted by: {{ idea.user.name }} at {{ idea.created_at }}</p>
    <p>Comments Count: {{ idea.content }}</p>
    <p>Likes: {{ idea.likes }}</p>
  </div>
  <br>
  <label for="">Post a comment:</label><br>
  <textarea name="" id="" cols="60" rows="5" class="bg-gray-50 rounded-lg border border-gray-300 "></textarea>
  <p>Comments: </p>
  <div v-for="comment in idea.comments" >
    <hr>
      <p>{{ comment.content }}</p>
      <p class="">Posted by: {{ comment.user.name }} at {{ comment.created_at }}</p>
      <hr><br>
    </div>
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

  