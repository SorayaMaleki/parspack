<?php

namespace App\Http\Controllers;

use App\Services\Products\ProductsServiceInterface;
use App\Traits\Response\ApiResponse;
use Illuminate\Http\JsonResponse;

class ProductsController extends Controller
{
    use ApiResponse;

    /**
     * Bind service.
     *
     * @param ProductsServiceInterface $productService The product service implementation.
     */
    public function __construct(public ProductsServiceInterface $productService)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $product = $this->productService->getAllProducts()->toArray();
        return $this->successResponse($product, [__('api.list',['resource'=>'products'])]);
    }
}
