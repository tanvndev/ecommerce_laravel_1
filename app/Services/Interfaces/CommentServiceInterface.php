<?php

namespace App\Services\Interfaces;

/**
 * Interface CommentServiceInterface
 * @package App\Services\Interfaces
 */
interface CommentServiceInterface
{
    public function paginate($commentable_id, $commentable_type);
    public function create();
}
