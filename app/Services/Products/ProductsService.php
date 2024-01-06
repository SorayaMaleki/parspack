<?php

namespace App\Services\Products;

use App\Repositories\Products\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class CommentService
 *
 * @package App\Services
 */
class ProductsService implements ProductsServiceInterface
{

    /**
     * ProductService constructor.
     *
     * @param  ProductRepositoryInterface  $productRepository  Product
     *   repository instance.
     */
    public function __construct(
      public ProductRepositoryInterface $productRepository
    ) {
    }

    /**
     * Retrieve all products with associated comments.
     *
     * @return Collection
     */
    public function getAllProducts(): Collection
    {
        return $this->productRepository->all(["comments"]);
    }

}
