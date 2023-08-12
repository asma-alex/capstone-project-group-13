<template>
  <div >
    <div class="mt-8 flex justify-center items-center">
      <div class="rounded-lg lg:w-2/4 p-4">
        <p></p>
        <p><i class="fa-solid fa-user"></i> Username: @{{ user.getUserName }} </p>
        <p> <i class="fa-solid fa-envelope"></i> Email: {{ user.getUserEmail }} </p>
        
        <p>Ideas pinned: {{ ideaCount }}</p>
        
        
        <br>
        <p class="font-semibold text-2xl">Your posts:</p>
      </div>
      <RouterLink to="/create" class="py-4 font-bold px-8 hover:text-emerald-300 text-emerald-500 px-2 border-2 border-emerald-500 rounded-md hover:border-emerald-300 bg-white"><i class="fa-solid fa-thumbtack fa-lg"></i> Pin a new idea!</RouterLink>
    </div>
    <div>
      <br>
      
      <div>
        <!-- ideas -->
        <div v-for="idea in ideas" :key="idea.id" class=" flex justify-center items-center pb-8"> 
          <div class="border rounded-lg lg:w-2/4 p-4 bg-white">  
            <div class="flex justify-between">
              <p class="font-semibold text-2xl p-2">{{ idea.title }}</p>
              <!-- delete button -->
              <button @click="deleteIdea(idea.id)" class="hover:text-red-500 p-2">
              Delete <i class="fa-solid fa-delete-left p-2"></i></button>             
            </div>    
            
            <hr>
            <p class="p-2">{{ idea.content }}</p>
            
            <div class="flex justify-between">
              
              <div class="flex items-center">
                
                <router-link :to="'/idea/' + idea.id" 
                  class="text-emerald-500 hover:text-emerald-200 p-2 ">Go to Comments
                </router-link>
            
              </div>              
              <!--update buttons -->
              <button @click="editIdea(idea)" class="hover:text-blue-500 px-2 border border-black rounded-md hover:border-blue-500">Edit Post <i class="fa-solid fa-pen-to-square p-2"></i></button>
              
            </div>
                       
            <!-- edit idea form -->
            <div v-if="showForm === idea.id">
              <br><hr>
              <p class="my-2">Editing...</p>
              <input type="text" v-model="editTitle" name="" id="" 
                class="h-10 p-2 w-full border text-stone-600 border-gray-300 rounded-md focus:outline-none focus:border-emerald-500 hover:bg-stone-100" ><br><br>
              <textarea v-model="editContent" name="" id="" cols="30" rows="6" spellcheck="false"
                class="w-full p-2 border border-gray-300 text-stone-600  rounded-md focus:outline-none focus:border-emerald-500 hover:bg-stone-100" ></textarea>
              <button @click="updateIdea(idea)" class="my-4 font-bold mr-4 text-white bg-emerald-500 hover:bg-emerald-600 rounded p-2">
                <i class="fa-solid fa-check mr-2"></i>Confirm Changes</button>
                <button @click="hideForm()">Cancel</button>
            </div>
          </div> 
        </div>
      </div>
    </div>
    </div>
</template>

<script>
import { RouterLink } from 'vue-router';
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
      ideaCount() {
      return this.ideas.length;
    },
    },
    mounted() {
      this.fetchIdeas();
    },
    methods: {
      fetchIdeas() {
        //api fetch request
        const userId = this.$route.params.id;
        fetch(`http://127.0.0.1:8000/api/ideas/user/${userId}`)
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
        console.log(token)
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
        const token = this.user.authToken;
        fetch(`http://127.0.0.1:8000/api/ideas/${user.id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          },
          body: JSON.stringify(editedIdea),
        })
        //change the information on the idea array
        .then(response => response.json())
        .then(updatedIdea => {
          const index = this.ideas.findIndex(item => item.id === updatedIdea.id);
          this.ideas[index] = updatedIdea;        
        })
        //hide form atfer submit
        console.log(user.id)
        console.log(JSON.stringify(editedIdea))
        this.showForm = '';
      },
      hideForm() {
        this.showForm = '';
      }
    }
  };
</script>