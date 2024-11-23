<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\BookController;
use App\Http\Requests\Book\UpdateRequest;
use App\Http\Services\Book\Update;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfullyUpdatesBook(): void
    {
        $book = Book::factory()->create();
        $updateRequestMock = $this->createMock(UpdateRequest::class);
        $updateRequestMock->expects($this->once())
            ->method('validated')
            ->willReturn([
                'title' => 'Updated Title',
                'author' => 'Updated Author',
            ]);

        $updateService = $this->createMock(Update::class);
        $updateService->method('__invoke')->willReturn($book);

        $response = (new BookController())->update($updateRequestMock, $updateService, $book);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Successfully updated the book.', $response->getData()->message);
        $this->assertEquals($book->toArray(), (array)$response->getData()->data);
    }

    public function testFailsToUpdateBookWithInvalidData(): void
    {
        $book = Book::factory()->create();
        $updateRequestMock = $this->createMock(UpdateRequest::class);
        $updateRequestMock->expects($this->once())
            ->method('validated')
            ->willThrowException(ValidationException::withMessages([
                'rating' => 'The rating must be between 1 and 10.',
            ]));

        $updateService = $this->createMock(Update::class);
        $updateService
            ->method('__invoke')
            ->willReturn($book);

        $this->expectException(ValidationException::class);

        (new BookController())->update($updateRequestMock, $updateService, $book);
    }
}
