<?php

namespace App\Repositories\Interfaces;

interface LanguageRepositoryInterface extends BaseRepositoryInterface
{
    public function getCurrentLanguage();
}
