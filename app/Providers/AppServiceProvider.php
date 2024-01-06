<?php

namespace App\Providers;

use App\Repositories\Base\BaseRepository;
use App\Repositories\Base\BaseRepositoryInterface;
use App\Repositories\Comments\CommentRepository;
use App\Repositories\Comments\CommentRepositoryInterface;
use App\Repositories\Products\ProductRepository;
use App\Repositories\Products\ProductRepositoryInterface;
use App\Repositories\Users\UserRepository;
use App\Repositories\Users\UserRepositoryInterface;
use App\Services\Comments\CommentService;
use App\Services\Comments\CommentServiceInterface;
use App\Services\Products\ProductsService;
use App\Services\Products\ProductsServiceInterface;
use App\Services\Users\UserService;
use App\Services\Users\UserServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CommentServiceInterface::class,CommentService::class);
        $this->app->bind(ProductsServiceInterface::class,ProductsService::class);
        $this->app->bind(BaseRepositoryInterface::class,BaseRepository::class);
        $this->app->bind(CommentRepositoryInterface::class,CommentRepository::class);
        $this->app->bind(ProductRepositoryInterface::class,ProductRepository::class);
        $this->app->bind(UserRepositoryInterface::class,UserRepository::class);
        $this->app->bind(UserServiceInterface::class,UserService::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
