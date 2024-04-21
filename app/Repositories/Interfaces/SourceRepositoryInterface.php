<?php

namespace App\Repositories\Interfaces;

interface SourceRepositoryInterface extends BaseRepositoryInterface
{
    public function getSourceLanguageById($id = 0, $languageId = 0);
}
