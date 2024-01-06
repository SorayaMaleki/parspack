<?php

namespace App\Repositories\Comments;

use App\Models\Comment;
use App\Repositories\Base\BaseRepository;

class CommentRepository extends BaseRepository implements
  CommentRepositoryInterface
{

    /**
     * Binds the model to Contact class.
     *
     * @param  Comment  $model The Comment model to bind.
     */
    public function __construct(Comment $model)
    {
        $this->model = $model;
    }

}
