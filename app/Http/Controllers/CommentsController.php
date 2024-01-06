<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Services\Comments\CommentServiceInterface;
use App\Traits\Response\ApiResponse;
use Illuminate\Http\JsonResponse;

class CommentsController extends Controller
{
    use ApiResponse;

    /**
     * Bind service.
     *
     * @param CommentServiceInterface $commentService The comment service implementation.
     */
    public function __construct(public CommentServiceInterface $commentService)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCommentRequest $request The request instance.
     *
     * @return JsonResponse
     */
    public function store(StoreCommentRequest $request): JsonResponse
    {
        $comment = $this->commentService->createComment($request);
        return $this->successResponse($comment->toArray(), [__('api.created', ["resource"=>"comment"])],201);
    }
}
