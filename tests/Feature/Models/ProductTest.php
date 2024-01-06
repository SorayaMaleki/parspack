<?php

namespace Tests\Feature\Models;


use App\Models\Comment;
use App\Models\Product;
use App\Observers\CommentObserver;
use App\Observers\ProductObserver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function insert_data(): void
    {
        $data = Product::factory()->make()->toArray();
        Product::create($data);
        $this->assertDatabaseHas("products", $data);
    }
    /**
     * @test
     */
    public function product_relation_with_comment(): void
    {
        $count = rand(1, 2);
        $user = Product::factory()
          ->has(Comment::factory()->count($count))
          ->create();
        $this->assertCount($count, $user->comments);
        $this->assertTrue($user->comments->first() instanceof Comment);
    }
}
