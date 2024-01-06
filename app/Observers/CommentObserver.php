<?php

namespace App\Observers;

use App\Models\Comment;

class CommentObserver
{

    /**
     * Handle the "created" event for a Comment.
     *
     * @param  Comment  $comment  The newly created Comment instance.
     *
     * @return void
     */
    public function created(Comment $comment): void
    {
        if (osIsLinux()) {
            updateCommentCount($comment->product->title);
        }
    }


}
