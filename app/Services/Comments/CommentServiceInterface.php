<?php

namespace App\Services\Comments;

use App\Http\Requests\StoreCommentRequest;

interface CommentServiceInterface
{

    /**
     * @param  StoreCommentRequest  $request
     */
    public function createComment(StoreCommentRequest $request);
}
