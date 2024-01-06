<?php

namespace App\Repositories\Products;

use App\Models\Product;
use App\Repositories\Base\BaseRepository;

class ProductRepository extends BaseRepository implements
  ProductRepositoryInterface
{

    /**
     * Binds the model to Contact class.
     *
     * @param  Product  $model  The Product model to bind.
     */
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

}
