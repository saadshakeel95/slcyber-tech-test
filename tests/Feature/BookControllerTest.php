<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testUpdateBook()
    {
        $book = Book::factory()->create([
            'title' => 'Old Book Title',
            'author' => 'Old Author',
            'rating' => 4,
        ]);

        $data = [
            'title' => 'New Book Title',
            'author' => 'New Author',
            'rating' =>1,
        ];
        $response = $this->json('PUT', route('books.update', $book->id), $data);
        $response->assertStatus(200);

        $response->assertJson([
            'message' => 'Successfully updated the book.',
            'data' => [
                'title' => 'New Book Title',
                'author' => 'New Author',
                'rating' => 2,
            ],
        ]);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'New Book Title',
            'author' => 'New Author',
            'rating' => 4,
        ]);
    }

    public function testUpdateBookWithInvalidData()
    {
        $book = Book::factory()->create([
            'title' => 'Old Book Title',
            'author' => 'Old Author',
            'rating' => 2,
        ]);

        $data = [
            'title' => '',  // Empty title should fail validation
            'author' => 'New Author',
            'rating' => 3,
        ];

        $response = $this->json('PUT', route('books.update', $book->id), $data);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors('title');
    }
}
