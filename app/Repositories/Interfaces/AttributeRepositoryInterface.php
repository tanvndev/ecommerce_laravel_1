<?php

namespace App\Repositories\Interfaces;

interface AttributeRepositoryInterface extends BaseRepositoryInterface
{
    public function getAttributeLanguageById($id = 0, $languageId = 0);
}
