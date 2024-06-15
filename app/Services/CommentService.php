<?php

namespace App\Services;

use App\Classes\CommentNested;
use App\Repositories\Interfaces\CommentRepositoryInterface as CommentRepository;
use App\Services\Interfaces\CommentServiceInterface;
use Illuminate\Support\Facades\DB;

/**
 * Class CommentService
 * @package App\Services
 */
class CommentService extends BaseService implements CommentServiceInterface
{
    private $commentRepository;
    public function __construct(
        CommentRepository $commentRepository
    ) {
        $this->commentRepository = $commentRepository;
    }



    public function create()
    {
        DB::beginTransaction();
        try {
            $payload = request()->except('_token');
            $this->commentRepository->create($payload);

            // Dùng để tính toán lại các giá trị left right
            $this->nestedset = new CommentNested([
                'table' => 'comments',
                'commentable_type' => $payload['commentable_type'],
            ], $payload);
            $this->calculateNestedSet();
            DB::commit();
            return [
                'code' => 200,
                'message' => 'Đánh giá sản phẩm thành công.',
                'data' => []
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            echo ' mess: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile();
            die;
            return [
                'code' => 400,
                'message' => 'Có lỗi vui lòng thử lại.',
                'data' => []
            ];
        }
    }
}
