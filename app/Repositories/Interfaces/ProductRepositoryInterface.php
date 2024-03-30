<?php

namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function getProductLanguageById($id = 0, $languageId = 0);
}
