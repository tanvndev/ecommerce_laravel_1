<?php

namespace App\Repositories\Interfaces;

interface AttributeRepositoryInterface extends BaseRepositoryInterface
{
    public function getAttributeLanguageById($id = 0, $languageId = 0);
    public function searchAttributes($search = '', $option = '', $languageId = 0);
    public function findAttributeByIdArray($attributeArr = [], $languageId = 0);
}
