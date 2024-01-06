<?php

namespace Tests\Feature\Models;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function insert_data(): void
    {
        $data = User::factory()->create();
        $user = User::first();
        $this->assertEquals($data->name, $user->name);
        $this->assertEquals($data->email, $user->email);
    }

    /**
     * @test
     */
    public function user_relation_with_comment(): void
    {
        $count = rand(1, 10);
        $user = User::factory()
          ->has(Comment::factory()->count($count))
          ->create();
        $this->assertCount($count, $user->comments);
        $this->assertTrue($user->comments->first() instanceof Comment);
    }

    /** @test */
    public function only_fillable_fields_can_be_mass_assigned(): void
    {
        // Attempt to create a user with non-fillable fields
        $user = User::create([
          'name' => 'John Doe',
          'email' => 'john@example.com',
          'password' => bcrypt("123"),
          'is_admin' => false,
          'remember_token' => "hjgfjfjfjfj", // non-fillable field
          'email_verified_at' => "hjgfjfjfjfj", // non-fillable field
        ]);

        // Fetch the user from the database
        $savedUser = User::find($user->id);

        // Assert that non-fillable fields are not assigned
        $this->assertNull($savedUser->remember_token);
        $this->assertNull($savedUser->email_verified_at);
    }

}
