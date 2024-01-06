<?php

namespace App\Services\Comments;

use App\Exceptions\CommentValidationException;
use App\Http\Requests\StoreCommentRequest;
use App\Repositories\Comments\CommentRepositoryInterface;
use App\Repositories\Products\ProductRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentService implements CommentServiceInterface
{

    /**
     * CommentService constructor.
     *
     * @param  CommentRepositoryInterface  $commentRepository  Comment
     *   repository instance.
     * @param  ProductRepositoryInterface  $productRepository  Product
     *   repository instance.
     */
    public function __construct(
      public CommentRepositoryInterface $commentRepository,
      public ProductRepositoryInterface $productRepository
    ) {
    }

    /**
     * Create a new Comment.
     *
     * @param  StoreCommentRequest  $request  The request object.
     *
     * @return Model The created comment model.
     * @throws Exception
     */
    public function createComment(StoreCommentRequest $request): Model
    {
        return DB::transaction(function () use ($request) {
            $user_id = Auth::user()->getAuthIdentifier();
            $product = $this->getOrCreateProduct($request->product);
            $this->validateCommentCount($product, $user_id);
            $payload = $this->buildCommentPayload(
              $request,
              $product->id,
              $user_id
            );
            return $this->commentRepository->create($payload);
        });
    }

    /**
     * Get or create a product by its title.
     *
     * @param  string  $productName  The title of the product.
     *
     * @return Model The retrieved or newly created product model.
     */
    protected function getOrCreateProduct(string $productName): Model
    {
        return $this->productRepository->firstOrCreate(['title' => $productName]
        );
    }

    /**
     * Validate the comment count for a given product and user.
     *
     * @param  Model  $product  The product model.
     * @param  int  $user_id  The user ID.
     *
     * @return void
     * @throws CommentValidationException When the comment limit is exceeded.
     */
    protected function validateCommentCount(Model $product, int $user_id): void
    {
        $comments = $product->comments()->where('user_id', $user_id)->count();

        if ($comments >= 2) {
            throw new CommentValidationException('Comment limit exceeded.');
        }
    }

    /**
     * Build the payload for a comment.
     *
     * @param  StoreCommentRequest  $request  The request object.
     * @param  int  $product_id  The ID of the product related to the comment.
     * @param  int  $user_id  The ID of the user creating the comment.
     *
     * @return array The constructed comment payload.
     */
    protected function buildCommentPayload(
      StoreCommentRequest $request,
      int $product_id,
      int $user_id
    ): array {
        $payload = $request->toArray();
        $payload['product_id'] = $product_id;
        $payload['user_id'] = $user_id;

        return $payload;
    }

}
