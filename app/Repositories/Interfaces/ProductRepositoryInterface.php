<?php

namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function getProductLanguageById($id = 0, $languageId = 1);
    public function findProductForPromotion($condition = [], $relation = []);
    public function filter($params, $perPage = 18);
}
