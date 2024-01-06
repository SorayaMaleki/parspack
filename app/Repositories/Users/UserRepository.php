<?php

namespace App\Repositories\Users;

use App\Models\User;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Comments\CommentRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    /**
     * Binds the model to Contact class.
     *
     * @param  User  $model  The User model to bind.
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

}
