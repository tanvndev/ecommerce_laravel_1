<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Services\Interfaces\CommentServiceInterface as CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private $commentService;
    public function __construct(
        CommentService $commentService
    ) {
        parent::__construct();
        $this->commentService = $commentService;
    }

    public function store(StoreCommentRequest $request)
    {
        $comment = $this->commentService->create();
        return response()->json($comment);
    }
}
