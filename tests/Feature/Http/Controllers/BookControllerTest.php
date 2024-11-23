<?php

namespace Feature\Http\Controllers;

use App\Models\Book;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdatesBooksCorrectly(): void
    {
        $bookId = Book::factory()->create()->id;

        $response = $this->patch(route('books.update', $bookId), [
            'title' => 'Updated Title',
            'author' => 'Updated Author',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Successfully updated the book.',
            'data' => [
                'id' => $bookId,
                'title' => 'Updated Title',
                'author' => 'Updated Author',
            ]
        ]);
    }

    public function testFailsToUpdateBookWithInvalidData(): void
    {
        $this->expectException(ValidationException::class);

        $bookId = Book::factory()->create()->id;

        $response = $this->withoutExceptionHandling()->patch(route('books.update', $bookId), [
            'rating' => 11,
            'genres' => ['one', 'two', 'three'],
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('rating');
    }

    public function testFailsToUpdateNonExistentBook(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $response = $this->withoutExceptionHandling()->patch(route('books.update', 1000), [
            'title' => 'Updated Title',
            'author' => 'Updated Author',
        ]);

        $response->assertStatus(404);
    }
}
