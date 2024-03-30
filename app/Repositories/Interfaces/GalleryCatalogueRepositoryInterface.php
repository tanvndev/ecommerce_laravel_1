<?php

namespace App\Repositories\Interfaces;

interface GalleryCatalogueRepositoryInterface extends BaseRepositoryInterface
{
    public function getGalleryCatalogueLanguageById($id = 0, $languageId = 0);
}
