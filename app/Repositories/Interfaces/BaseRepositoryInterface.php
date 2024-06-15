<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    public function all($relation = [], $column = ['*'], $orderBy = null);
    public function findById($modelId, $column = ['*'], $relation = []);
    public function findByWhere($conditions = [], $column = ['*'], $relation = [], $all = false, $orderBy = null, $whereInParams = [], $withCount = []);
    public function findByWhereHas($condition = [], $column = ['*'], $relation = [], $alias = '', $all = false);
    public function create($payload = []);
    public function createBatch($payload = []);
    public function createPivot($model, $payload = [], $relation = '');
    public function update($modelId, $payload = []);
    public function save($modelId, $payload = []);
    public function updateByWhereIn($whereInField = '', $whereIn = [], $payload = []);
    public function updateByWhere($condition = [], $payload = []);
    public function delete($modelId);
    public function updateOrInsert($payload = [], $conditions = []);
    public function deleteByWhere($conditions = []);
    public function forceDelete($modelId);
    public function forceDeleteByWhere($conditions);
    public function pagination(
        $column = ['*'],
        $condition = [],
        $perPage = 1,
        $orderBy = [],
        $join = [],
        $relations = [],
        $groupBy = [],
        $rawQuery = [],
    );
    public function findWidgetItem($condition = [], $column = ['*'], $alias = '', $languageId = 1);
    public function recursiveCategory($ids = [], $table);
    public function findObjectByCategoryIds($ids, $model, $languageId);
    public function breadcrumb($model, $languageId = 1);
}
