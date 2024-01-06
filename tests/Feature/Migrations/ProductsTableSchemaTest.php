<?php

namespace Tests\Feature\Migrations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ProductsTableSchemaTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function products_table_has_expected_columns()
    {
        $expected = [
          "id",
          "title",
          "created_at",
          "updated_at",
        ];
        $schema = Schema::getColumnListing('products');
        $this->assertEquals($expected, $schema);
    }

}
