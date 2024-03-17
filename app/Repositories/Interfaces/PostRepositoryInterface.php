<?php

namespace App\Repositories\Interfaces;

interface PostRepositoryInterface extends BaseRepositoryInterface
{
    public function getPostLanguageById($id = 0, $languageId = 0);
}
