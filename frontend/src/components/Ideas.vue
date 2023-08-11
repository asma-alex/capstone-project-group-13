<template>
    <div >
      <div class="my-8 flex justify-center items-center">
        <div class="lg:w-3/4">
          <div class="flex justify-between">
            <p class="font-semibold text-4xl">Bulletn board:</p>
            
          </div>
                             
        </div>
      </div>
      <!-- sorting mwnu -->
      <div class="my-8 flex justify-center items-center">
        <div class="lg:w-3/4">
          <div class="flex justify-between">
            <div>
              <label for="sort">Sort: </label>
          <select v-model="selectedSort" id="sort" @change="sortIdeas" class="rounded p-2">
            <option value="new">New</option>
            <option value="old">Old</option>
            <option value="likes">Pins</option>
          </select>
            </div>
          
          <div v-if="user.isAuthenticated">
              <RouterLink to="/create" class="py-4 font-bold px-8 hover:text-emerald-300 text-emerald-500 px-2 border-2 border-emerald-500 rounded-md hover:border-emerald-300 bg-white"><i class="fa-solid fa-thumbtack fa-lg"></i> Post your own idea!</RouterLink>
            </div>
            </div>
        </div>
      
    </div>
      
      <!-- ideas -->
        <div v-for="idea in ideas" 
        :key="idea.id" class="my-8 flex justify-center items-center">
        <div class="border rounded-lg lg:w-3/4 p-4 bg-white">
          <!-- Like and dislike -->
          <div class="">
          <div v-if="user.isAuthenticated">
            <button @click="likeIdea(idea.id)"
              >
          <i class="fa-solid fa-thumbtack fa-lg"></i> {{ idea.likes_count }} pin(s)
        </button>
          </div>
          <div v-if="!user.isAuthenticated"> <i class="fa-solid fa-thumbtack fa-lg"></i> {{ idea.likes_count }} pin(s)</div>
        
          <p class="font-semibold text-2xl p-2">{{ idea.title }} </p> <hr>
          </div>
          <p class="text-zinc-400 p-2">Posted by: @{{ idea.user.name }} at {{ formatTime(idea.created_at) }}</p>
          <p class="p-2">{{ idea.content }}</p>
          
          

          <div v-if="user.isAuthenticated">
    </div>           
          <router-link :to="'/idea/' + idea.id" 
          class="text-emerald-500 hover:text-emerald-200 p-2">
          View Comments ({{ idea.comments_count }})</router-link>
          </div>
        </div>
      </div>
  </template>
  
<script>
import moment from 'moment';
import { useUserStore } from '@/store/userStore';
export default {
  data() {
    return {
      ideas: [], 
      selectedSort: '',
      
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
    formatTime(time) {
      return moment(time).format('YYYY-MM-DD h:mm A');
    },
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
    },
    likeIdea(ideaId) {
      const userId = this.user.getUserId;
      const token = this.user.authToken;
      fetch(`http://127.0.0.1:8000/api/ideas/${ideaId}/${userId}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': `Bearer ${token}`
        },
      })
      .then(response => {
        if (response.ok) {
          //update front end ideas[] array when like is clicked
          const ideaIndex = this.ideas.findIndex(idea => idea.id === ideaId);
          this.ideas[ideaIndex].likes_count++;
          //update like color
          // const user = this.user;
          const userId = this.user.getUserId;
          if (!this.ideas[ideaIndex].likes.some(e => e.id === userId)) {
             this.ideas[ideaIndex].likes.push(userId);
          console.log(this.getUserId)
          console.log(user, 'this is the user')
          }
          console.log(this.user.id, 'this is when user id is not stored in const')
          console.log(userId)
          
        }
      });
    },
    sortIdeas() {
      console.log('sorting change');
    
      const sortedIdeas = [...this.ideas];
      console.log(sortedIdeas);

      if (this.selectedSort === 'new') {
        sortedIdeas.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
      } else if (this.selectedSort === 'old') {
        sortedIdeas.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
      } else if (this.selectedSort === 'likes') {
        sortedIdeas.sort((a, b) => b.likes_count - a.likes_count);
      }

      this.ideas = sortedIdeas;
    },
},
};
</script>
