<template>
    <div class="flex justify-center">
        <div>
            <form action="" @submit.prevent="createIdea">
                <p>Create an Idea</p>
                <label for="">Title</label><br>
                <input type="text" v-model="title" name="" id=" "  class="bg-gray-50 rounded-lg border border-gray-300 "><br>
                <input type="hidden" >
                <label for="">Post</label><br>
                <textarea v-model="content" name="" id="" cols="30" rows="10" class="bg-gray-50 rounded-lg border border-gray-300 "></textarea><br>
                <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Share Your Idea</button>
            </form>
        </div>
    
</div>
</template>

<script>
//get id
export default {
  data() {
    return {
      title: '',
      content: '',
    };
  },
  methods: {
    createIdea() {
      const token = localStorage.getItem('token'); 
      if (token) {
        const idea = {
          title: this.title,
          content: this.content,
          user_id: 1,
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