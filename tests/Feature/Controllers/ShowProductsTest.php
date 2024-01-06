<?php

namespace Tests\Feature\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tests\TestHelper;

class ShowProductsTest extends TestCase
{
    use RefreshDatabase;
    use TestHelper;

    private const ROUTE = 'products.index';
    /** @test */
    public function it_return_unauthenticated_if_user_not_logged_in()
    {
        $product = Product::factory()->create();

        $attributes = [
          "content" => Str::random(10),
          "product" => $product->title,
        ];
        $response = $this->postJson(route(self::ROUTE), $attributes)
          ->assertStatus(401);
        $expectedResponse=$this->errorResponse([__('auth.Unauthenticated')],401);
        $response->assertJson($expectedResponse);
    }

    /** @test */
    public function it_returns_all_product_with_comments()
    {
        // Create a test article
        $user=User::factory()->create();
        $products=Product::factory()
          ->has(Comment::factory(["user_id"=>$user->id])->count(2))
          ->count(5)->create();
        $this->actingAs($user);

        // Access the edit route for the article
        $response = $this->get(route(self::ROUTE));
        $expectedResponse=$this->successResponse($products->load("comments")->toArray(),[__('api.list',["resource"=>"products"])]);
        $response->assertExactJson($expectedResponse);
    }

}
