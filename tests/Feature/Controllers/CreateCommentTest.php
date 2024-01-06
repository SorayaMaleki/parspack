<?php

namespace Tests\Feature\Controllers;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tests\TestHelper;

class CreateCommentTest extends TestCase
{

    use RefreshDatabase;
    use TestHelper;

    private const ROUTE = 'comments.store';

    /**
     * @test
     * @dataProvider commentsDataProvider
     */
    public function validateCommentFields(
      $fieldName,
      $testVal,
      $errorMessage,
      $format = []
    ) {
        $user = User::factory()->create();
        $this->actingAs($user);
        $standardAttributes = Comment::factory([$fieldName => $testVal])->raw();

        $expectedResponse = $this->errorResponse([
          $fieldName => [
            __($errorMessage,['attribute' => $fieldName, ...$format]),
          ],
        ],422);
        $this->postJson(route(self::ROUTE), $standardAttributes)
          ->assertStatus(422)
          ->assertJson($expectedResponse);
    }


    /**
     * Data providers of business.
     *
     * @return array
     */
    public function commentsDataProvider(): array
    {
        return [
          'test content is required' => ['content', '', 'validation.required'],
          'test product is required' => ['product', '', 'validation.required'],
          'content field must be at most 400000 characters' => [
            'content',
            Str::random(400005),
            'validation.max.string',
            ['max' => 400000],
          ],
          'product field must be at most 255 characters' => [
            'product',
            Str::random(256),
            'validation.max.string',
            ['max' => 255],
          ],
        ];
    }
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
    public function it_create_comment_if_product_exist_before()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $this->actingAs($user);

        $attributes = [
          "content" => Str::random(10),
          "product" => $product->title,
        ];
        $response = $this->postJson(route(self::ROUTE), $attributes)
          ->assertStatus(201);

        $expectedResponse=$this->successResponse(
          [
            "content" => $attributes["content"],
            "user_id" => $user->id,
            "product_id" => $product->id,
          ]
          ,[__('api.created', ['resource' => 'comment'])],201);
        $response->assertJson($expectedResponse);
        $this->assertDatabaseHas('comments',
          [
            "content" => $attributes["content"],
            "user_id" => $user->id,
            "product_id" => $product->id,
          ]
        );
    }

    /** @test */
    public function it_create_comment_if_product_not_exist_before()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $attributes = [
          "content" => Str::random(10),
          "product" => Str::random(5),
        ];
        $response = $this->postJson(route(self::ROUTE), $attributes)
          ->assertStatus(201);
        $product=Product::where("title",$attributes['product'])->first();
        $expectedResponse=$this->successResponse(
          [
            "content" => $attributes["content"],
            "user_id" => $user->id,
            "product_id" => $product->id,
          ]
          ,[__('api.created', ['resource' => 'comment'])],201);
        $response->assertJson($expectedResponse);
        $this->assertDatabaseHas('comments',
          [
            "content" => $attributes["content"],
            "user_id" => $user->id,
            "product_id" => $product->id,
          ]
        );
        $this->assertDatabaseHas('products',
          [
            "title" => $attributes["product"],
          ]
        );
    }


}

