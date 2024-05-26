<?php

namespace App\Repositories\Interfaces;

interface AttributeCatalogueRepositoryInterface extends BaseRepositoryInterface
{
    public function getAttributeCatalogueLanguageById($id = 0, $languageId = 0);
    public function getAll($languageId = 0);
    public function getAttributeCatalogueLanguageWhereIn($whereIn = [], $whereInField = 'id', $languageId = 1);
}
