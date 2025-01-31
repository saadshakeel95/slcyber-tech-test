<template>
   <div>
    <div class="bg-gray-800 pt-8 pb-20">
            <div class="w-9/12 text-center mr-auto ml-auto -mt-0 mb-0">
            <h1 class="text-orange text-5xl p-10">Book Shop</h1>
            <p class="w-9/12 mr-auto ml-auto -mt-0 mb-0 text-white">Cupcake ipsum dolor sit amet croissant. I love topping candy canes sweet roll croissant caramels. Soufflé macaroon liquorice chocolate tart I love.</p>
        </div>
    </div>
    <input
      type="text"
      v-model="searchQuery"
      placeholder="Search by book title..."
      class="border p-2 rounded w-full my-4"
      @input="fetchBooks"
    />

    <table class="w-full border-collapse border">
      <thead>
        <tr>
          <th class="border p-2">Title</th>
          <th class="border p-2">Author</th>
          <th class="border p-2">Rating</th>
          <th class="border p-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="book in books.data" :key="book.id">
          <td class="border p-2">{{ book.title }}</td>
          <td class="border p-2">{{ book.author }}</td>
          <td class="border p-2">{{ book.rating }}</td>
          <td class="border p-2">
            <a href="#" class="text-blue-500">Edit</a> | 
            <a href="#" class="text-red-500">Delete</a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
import axios from "axios";

export default {
  data() {
    return {
      books: [],
      searchQuery: "",
    };
  },
  methods: {
    async fetchBooks() {
      const response = await axios.get("/api/books", {
        params: { search: this.searchQuery },
      });
      this.books = response.data;
    },
  },
  created() {
    this.fetchBooks();
  },
};
</script>

<style>
</style>
