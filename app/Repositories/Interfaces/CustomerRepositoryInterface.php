<?php

namespace App\Repositories\Interfaces;

interface CustomerRepositoryInterface extends BaseRepositoryInterface
{
    public function getCustomerLanguageById($id = 0, $languageId = 0);
}
