<?php

namespace App\Http\Controllers\Servers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Services\Interfaces\CommentServiceInterface as CommentService;
use App\Repositories\Interfaces\CommentRepositoryInterface as CommentRepository;


class CommentController extends Controller
{
    protected $commentService;
    protected $commentRepository;

    // Sử dụng dependency injection chuyển đổi đối tượng của một lớp được đăng ký trong container
    public function __construct(
        CommentService $commentService,
        CommentRepository $commentRepository,
    ) {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            return $next($request);
        });

        $this->commentService = $commentService;
        $this->commentRepository = $commentRepository;
    }


    public function index($commentable_id, $commentable_type)
    {
        $this->authorize('modules', 'comment.index');

        $comments = $this->commentService->paginate($commentable_id, $commentable_type);
        // dd($comments);
        $config['seo'] = __('messages.comment')['index'];

        return view('servers.comments.index', compact([
            'comments',
            'config',
        ]));
    }
}
