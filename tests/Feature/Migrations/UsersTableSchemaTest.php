<?php

namespace Tests\Feature\Migrations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UsersTableSchemaTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function users_table_has_expected_columns()
    {
        $expected = [
          "id",
          "name",
          "email",
          "email_verified_at",
          "password",
          "remember_token",
          "created_at",
          "updated_at",
        ];
        $schema = Schema::getColumnListing('users');
        $this->assertEquals($expected, $schema);
    }

}
