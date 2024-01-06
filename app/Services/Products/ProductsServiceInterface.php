<?php

namespace App\Services\Products;

use Illuminate\Database\Eloquent\Collection;

interface ProductsServiceInterface
{

    /**
     * Retrieve all products with associated comments.
     *
     * @return Collection
     */
    public function getAllProducts(): Collection;

}
