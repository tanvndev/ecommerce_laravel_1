<?php

namespace App\Repositories\Interfaces;

interface WidgetRepositoryInterface extends BaseRepositoryInterface
{
    public function getWidgetWhereIn($keyword = [], $whereInField = 'keyword');
}
