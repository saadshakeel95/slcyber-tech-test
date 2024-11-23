<template>
    <div class="min-h-screen">
        <BookShopHeader/>
        <div class="w-1/5 text-left mr-auto ml-auto -mt-0 mb-0">
            <form @submit.prevent="submit">
                <div class="pt-10">
                    <h2 class="text-center text-3xl pb-10">Edit Book</h2>
                    <div class="pb-10">
                        <label class="w-20 inline-block">Title: </label>
                        <input
                            type="text"
                            v-model="form.title"
                            placeholder="Title"
                            class="rounded-md border-gray-400 border-solid border-[1px] p-2 w-96"
                        />
                    </div>
                    <div class="pb-10">
                        <label class="w-20 inline-block">Author: </label>
                        <input
                            type="text"
                            v-model="form.author"
                            placeholder="Author"
                            class="rounded-md border-gray-400 border-solid border-[1px] p-2 w-96"
                        />
                    </div>
                    <div class="pb-10">
                        <label class="w-20 inline-block">Rating: </label>
                        <input
                            type="text"
                            v-model="form.rating"
                            placeholder="5"
                            class="rounded-md border-gray-400 border-solid border-[1px] p-2 w-96"
                        />
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
import BookShopHeader from "./BookShopHeader.vue";

export default {
    name: 'EditBook',
    props: {
        bookId: {
            type: Number,
            required: true,
        },
    },
    components: {
        BookShopHeader,
    },
    data() {
        return {
            form: {
                title: "",
                author: "",
                rating: 5,
            },
        };
    },
    methods: {
        async fetchBookDetails() {
            try {
                const response = await fetch(`/api/books/${this.bookId}`);

                if (!response.ok) throw new Error("Failed to fetch book details");

                const data = await response.json();

                this.form.title = data.data.title;
                this.form.author = data.data.author;
                this.form.rating = data.data.rating;
            } catch (error) {
                alert("Error fetching book details:", error);
            }
        },
        async submit() {
            try {
                const response = await fetch(`/api/books/${this.bookId}`, {
                    method: "PATCH",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(this.form),
                });

                if (!response.ok) throw new Error("Failed to update book details");

                alert("Book details updated successfully!");

                await this.fetchBookDetails();
            } catch (error) {
                alert("Error updating book details:", error);
            }
        },
    },
    mounted() {
        if (this.bookId) {
            this.fetchBookDetails();
        }
    },
}
</script>
