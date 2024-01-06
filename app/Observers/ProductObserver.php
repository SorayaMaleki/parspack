<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductObserver
{

    /**
     * Handle the "created" event for a Product.
     *
     * @param  Product  $product  The newly created Product instance.
     *
     * @return void
     */
    public function created(Product $product): void
    {
        if (osIsLinux()) {
            addCommentCount($product->title);
        }
    }

}
