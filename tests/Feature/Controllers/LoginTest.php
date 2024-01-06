<?php

namespace Tests\Feature\Controllers;


use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\TestHelper;


class LoginTest extends TestCase
{

    use RefreshDatabase;
    use TestHelper;

    private const ROUTE = 'login';


    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $attributes = User::factory()->raw([
          'email' => "soraya@gmail.acom",
          "password" => "123456Mm!",
          "password_confirmation" => "123456Mm!",
        ]);
        $this->postJson(route('register'), $attributes)->assertStatus(201);
    }

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
            'validation.exists',
          ],
          'password field is required' => [
            'password',
            '',
            'validation.required',
          ],
        ];
    }

    /** @test */
    public function user_can_log_in()
    {
        $result= $this->postJson(route(self::ROUTE), [
            'email' => "soraya@gmail.acom",
            "password" => "123456Mm!",
          ]
        )->assertOk();
        $result->assertSee("token");
        $result->assertSee("user");
        $array=json_decode($result->content(),true);
        $this->assertEquals("soraya@gmail.acom",$array['body']['user']['email']);
    }

    /**
     * @test
     * @throws Exception
     */
    public function user_with_wrong_credentials_gets_wrong_credentials_error()
    {
        $expectedResponse = $this->errorResponse(
          [__('auth.Unauthenticated')],
          401
        );
        $attributes = [
          'email' => "soraya@gmail.acom",
          "password" => "123456pp",
        ];
        $this->postJson(route(self::ROUTE), $attributes)->assertJson(
          $expectedResponse
        );
    }

    /**
     * @test
     */
    public function user_can_log_out()
    {
        $attributes = [
          'email' => "soraya@gmail.acom",
          "password" => "123456Mm!",
        ];
        $result = $this->postJson(route(self::ROUTE), $attributes);
        $array = json_decode($result->content(), true);
        $token = $array['body']['token'];
        $user = User::first();
        $this->actingAs($user)->post(
          route('logout'),
          [],
          ['Authorization' => 'Bearer '.$token]
        )
          ->assertStatus(200);
    }

}
