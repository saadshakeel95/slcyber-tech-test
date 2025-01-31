<template>
   <div>
    <h1 class="text-center text-2xl font-bold my-4 text-orange-500">Book Shop</h1>
    <p class="text-center">Cupcake ipsum dolor sit amet croissant...</p>

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
