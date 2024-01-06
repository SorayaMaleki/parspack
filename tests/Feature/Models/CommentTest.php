<?php

namespace Models;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use App\Observers\CommentObserver;
use App\Observers\ProductObserver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function insert_data(): void
    {
        $data = Comment::factory()->make()->toArray();
        Comment::create($data);
        $this->assertDatabaseHas("comments", $data);
    }


    /** @test */
    public function comment_relation_with_user(): void
    {
        $article = Comment::factory()->create();
        $this->assertTrue(isset($article->user_id));
        $this->assertTrue($article->user->first() instanceof User);
    }

    /** @test */
    public function comment_relation_with_product(): void
    {
        $article = Comment::factory()->create();
        $this->assertTrue(isset($article->product_id));
        $this->assertTrue($article->product->first() instanceof Product);
    }

}
