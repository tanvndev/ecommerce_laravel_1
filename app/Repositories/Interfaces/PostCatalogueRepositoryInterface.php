<?php

namespace App\Repositories\Interfaces;

interface PostCatalogueRepositoryInterface extends BaseRepositoryInterface
{
    public function getPostCatalogueLanguageById($id = 0, $languageId = 0);
}
