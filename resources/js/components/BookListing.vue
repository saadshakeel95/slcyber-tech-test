<template>
    <div class="min-h-screen">
        <BookShopHeader/>
        <div class="container mx-auto p-6">
            <div class="flex justify-end pb-6">
                <input
                    type="text"
                    placeholder="Search by book title ..."
                    v-model="searchQuery"
                    class="w-1/3 p-2 border border-gray-400 rounded focus:outline-none focus:ring-2 focus:ring-orange-500"
                    @input="handleSearch"
                />
            </div>

            <div v-if="isLoading" class="text-center text-orange-500">Loading...</div>
            <table
                v-if="!isLoading && books.length > 0"
                class="table-auto w-full border-collapse border border-gray-600 text-left"
            >
                <thead class="bg-gray-700 text-white">
                <tr>
                    <th class="px-4 py-2 border border-white">Title</th>
                    <th class="px-4 py-2 border border-white">Author</th>
                    <th class="px-4 py-2 border border-white">Rating</th>
                    <th class="px-4 py-2 border border-white"></th>
                </tr>
                </thead>
                <tbody>
                <tr
                    v-for="(book, index) in books"
                    :key="index"
                    class="bg-gray-200 text-black"
                >
                    <td class="px-4 py-2 border border-white">{{ book.title }}</td>
                    <td class="px-4 py-2 border border-white">{{ book.author }}</td>
                    <td class="px-4 py-2 border border-white">{{ book.rating }}</td>
                    <td class="px-4 py-2 border border-white">
                        <a
                            class="text-black font-bold underline mr-2"
                            :href="'edit/' + book.id"
                        >Edit
                        </a>
                        <button
                            class="text-black font-bold underline"
                            @click="deleteBook(book.id)"
                        >Delete
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>

            <div v-if="!isLoading && books.length === 0" class="text-center text-gray-400">
                No books found.
            </div>
        </div>
    </div>
</template>

<script>
import BookShopHeader from "./BookShopHeader.vue";

export default {
    name: 'BookListing',
    components: {
        BookShopHeader,
    },
    data() {
        return {
            searchQuery: '',
            books: [],
            isLoading: false,
        };
    },
    methods: {
        async fetchBooks(search = "") {
            this.isLoading = true;

            try {
                const response = await fetch(`/api/books?search=${encodeURIComponent(search)}`);

                if (!response.ok) throw new Error("Failed to fetch books");

                const data = await response.json();
                this.books = data.data;
            } catch (error) {
                alert("Error fetching books:", error);
            } finally {
                this.isLoading = false;
            }
        },
        async deleteBook(index) {
            const book = this.books[index];

            try {
                const response = await fetch(`/api/books/${book.id}`, {
                    method: "DELETE",
                });

                if (!response.ok) throw new Error("Failed to delete book");

                await this.fetchBooks();
            } catch (error) {
                alert("Error deleting book:", error);
            }
        },
        handleSearch() {
            this.fetchBooks(this.searchQuery);
        },
    },
    mounted() {
        this.fetchBooks();
    }
}
</script>

<style>
</style>
