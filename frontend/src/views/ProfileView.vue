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
          <router-link :to="'/idea/' + idea.id" class="text-emerald-500 hover:text-emerald-200">View Comments</router-link>
          <button @click="deleteIdea(idea.id)">Delete Idea {{ idea.id }} </button>
          <button @click="editIdea(idea)">Edit Idea {{ idea.id }} </button>
          <hr />
          <!-- edit idea form -->
          <div v-if="showForm === idea.id">
            <p>edit inputs</p>
            <label for="">Post title: </label>
            <input type="text" v-model="editTitle" name="" id="" class="h-10 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500">
            <label for="">Post Content</label>
            <textarea v-model="editContent" name="" id="" cols="30" rows="10" class="border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"></textarea>
            <button @click="updateIdea(idea)">Submit Edit</button>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
import { useUserStore } from '@/store/userStore';
export default {
    data() {
      return {
        ideas: [], 
        showForm: '',  
        editTitle: '',
        editContent: '',     
      };
    },
    computed: {
      user() {
      return useUserStore();
      },
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
      },
      //delete an idea
      deleteIdea(ideaId) {
        const token = this.user.authToken;
        fetch(`http://127.0.0.1:8000/api/ideas/${ideaId}`, {
          method: 'DELETE',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          },
        })
        // removes idea from data array
        this.ideas = this.ideas.filter(idea => idea.id !== ideaId);
      },
      editIdea(idea) {
        console.log('editing')
        this.showForm = idea.id;
        this.editTitle = idea.title
        this.editContent = idea.content
      },
      updateIdea(user) {
        const editedIdea = {
          title: this.editTitle,
          content: this.editContent,
        }
        fetch(`http://127.0.0.1:8000/api/ideas/${user.id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            //'Authorization': `Bearer ${token}`
          },
          body: JSON.stringify(editedIdea),
        })
        console.log(user.id)
        console.log(JSON.stringify(editedIdea))
        this.showForm = '';
      }
    }
  };
</script>