<?php

namespace Tests\Feature\Controllers;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tests\TestHelper;


class RegisterTest extends TestCase
{

    use RefreshDatabase;
    use TestHelper;

    private const ROUTE = 'register';


    /**
     * @test
     * @dataProvider userDataProvider
     */
    public function validateUserFields(
      $fieldName,
      $testVal,
      $errorMessage,
      $format = []
    ) {
        $standardAttributes = User::factory([$fieldName => $testVal])->raw();

        $expectedResponse = $this->errorResponse([
          $fieldName => [
            __($errorMessage, ['attribute' => $fieldName, ...$format]),
          ],
        ], 422);

        $this->postJson(route(self::ROUTE), $standardAttributes)
          ->assertStatus(422)
          ->assertJson($expectedResponse);
    }


    /**
     * Data providers of user.
     *
     * @return array
     */
    public function userDataProvider(): array
    {
        return [
          'email field is required' => ['email', '', 'validation.required'],
          'The selected email is invalid.' => [
            'email',
            'ddd',
            'validation.email',
          ],
          'password field is required' => [
            'password',
            '',
            'validation.required',
          ],
          'name field is required' => ['name', '', 'validation.required'],
          'The name must be a string.' => ['name', 1, 'validation.string'],
          'The name must be at least 2 characters.' => [
            'name',
            'a',
            'validation.min.string',
            ['min' => 2],
          ],
          'The name must not be greater than 255 characters.' => [
            'name',
            Str::random(256),
            'validation.max.string',
            ['max' => 255],
          ],
        ];
    }

    /**
     * @test
     */
    public function password_has_specific_regex()
    {
        $standardAttributes = User::factory([
          'password' => '123456',
          'password_confirmation' => '123456',
        ])->raw();
        $expectedResponse = $this->errorResponse([
          'password' => [
            __(
              'validation.password_regex',
              ['attribute' => __('validation.attributes.password')]
            ),
          ],
        ],422);
        $this->postJson(route(self::ROUTE), $standardAttributes)
          ->assertStatus(422)
          ->assertJson($expectedResponse);
    }

    /**
     * @test
     */
    public function password_confirmation_should_match_password()
    {
        $standardAttributes = User::factory(
          ['password' => '123456aA', 'password_confirmation' => '123456']
        )->raw();
        $expectedResponse = $this->errorResponse([
          'password' => [
            __(
              'validation.confirmed',
              ['attribute' => __('validation.attributes.password')]
            ),
          ],
        ],422);
        $this->postJson(route(self::ROUTE), $standardAttributes)
          ->assertStatus(422)
          ->assertJson($expectedResponse);
    }

    /** @test */
    function user_can_be_registered()
    {
        $attributes = User::factory()->raw(
          ['email' => 'soraya@gmail.com', 'password' => '123456aA']
        );
        $this->postJson(
          route(self::ROUTE),
          array_merge($attributes, [
            'password_confirmation' => '123456aA'])
        )->assertStatus(201);
    }

}
