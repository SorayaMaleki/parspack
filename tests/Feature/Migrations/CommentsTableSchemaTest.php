<?php

namespace Tests\Feature\Migrations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CommentsTableSchemaTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function comments_table_has_expected_columns()
    {
        $expected = [
          "id",
          "user_id",
          "product_id",
          "content",
          "created_at",
          "updated_at",
        ];
        $schema = Schema::getColumnListing('comments');
        $this->assertEquals($expected, $schema);
    }

}
