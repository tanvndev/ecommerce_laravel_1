<?php

namespace App\Repositories\Interfaces;

interface SlideRepositoryInterface extends BaseRepositoryInterface
{
    public function getSlideLanguageById($id = 0, $languageId = 0);
}
