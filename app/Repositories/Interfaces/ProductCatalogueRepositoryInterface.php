<?php

namespace App\Repositories\Interfaces;

interface ProductCatalogueRepositoryInterface extends BaseRepositoryInterface
{
    public function getProductCatalogueLanguageById($id = 0, $languageId = 0);
}
