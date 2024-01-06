<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Repositories\Products\ProductRepositoryInterface;
use Illuminate\Console\Command;

class CreateProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new product';

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        parent::__construct();
        $this->productRepository = $productRepository;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $title = $this->ask('Enter title for product');
        $product = $this->productRepository->findByCriteria(["title" => $title]);

        if ($product) {
            $this->error("The title has already been taken");
        } else {
            $this->productRepository->create(["title" => $title]);
            $this->info("creation was successful");
        }
    }
}
