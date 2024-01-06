<?php

namespace Tests\Unit\Services;

use App\Repositories\Products\ProductRepositoryInterface;
use App\Services\Products\ProductsService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Mockery;
use PHPUnit\Framework\TestCase;


class ProductServiceTest extends TestCase
{
    public function setUp(): void
    {
        // Create a mock user
        $user = Mockery::mock(Authenticatable::class);
        $user->id = 1;
        $user->name = "asasas";
        $user->is_admin = 1;

        // Mock the behavior of Auth::user() to return the mock user
        Auth::shouldReceive('user')->andReturn($user);
        $this->reposirory = Mockery::mock(ProductRepositoryInterface::class);

    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    /** @test */
    public function it_gets_all_products()
    {
        $this->reposirory->shouldReceive('all')->once()->andReturn(new Collection());

        $service = new ProductsService($this->reposirory);
        $products = $service->getAllProducts();

        $this->assertInstanceOf(Collection::class, $products);
    }

}
