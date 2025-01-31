<template>
    <div>
        <div class="bg-gray-800 pt-8 pb-20">
            <div class="w-9/12 text-center mr-auto ml-auto -mt-0 mb-0">
            <h1 class="text-orange text-5xl p-10">Book Shop</h1>
            <p class="w-9/12 mr-auto ml-auto -mt-0 mb-0 text-white">Cupcake ipsum dolor sit amet croissant. I love topping candy canes sweet roll croissant caramels. Soufflé macaroon liquorice chocolate tart I love.</p>
        </div>
    </div>
        <div class="w-1/5 text-left mr-auto ml-auto -mt-0 mb-0">
            <form @submit.prevent="update">
                <div v-if="book" class="pt-10"> 
                    <h2 class="text-center text-3xl pb-10">Edit Book</h2>
                    <div class="pb-10">
                        <label class="w-20 inline-block">Title: </label>
                        <input type="text"  v-model="book.title" placeholder="Title" class="rounded-md border-gray-400 border-solid border-[1px] p-2 w-96">
                    </div>
                    <div class="pb-10">
                        <label class="w-20 inline-block">Author: </label>
                        <input type="text"  v-model="book.author" placeholder="Author" class="rounded-md border-gray-400 border-solid border-[1px] p-2 w-96">
                    </div>
                    <div class="pb-10">
                        <label class="w-20 inline-block">Rating: </label>
                        <input type="number" v-model="book.rating" placeholder="5" class="rounded-md border-gray-400 border-solid border-[1px] p-2 w-96">
                    </div>
                </div>
                <div class="text-center">
                    <button class="text-white bg-orange py-2 px-4 rounded" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {    
    name:"EditBook",
   props: ['bookId'],
  data() {
    return {
      book: {
        title: '',
        author: '',
        rating: ''
      }
    };
  },
  mounted() {
    axios.get(`/api/books/${this.bookId}}`)
      .then(response => {
        this.book = response.data;
      })
      .catch(error => {
        console.error("Error fetching book data", error);
      });
  },
  methods: {
    async update(){
     await
      axios.put(`/api/books/${this.bookId}`, this.book)
        .then(response => {
          alert('Book updated successfully!');
        })
        .catch(error => {
          console.error("Error updating book", error);
        });
    }
  }
};
</script>
