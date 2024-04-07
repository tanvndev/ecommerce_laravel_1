<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    public function all($relation = []);
    public function findById($modelId, $column = ['*'], $relation = []);
    public function findByWhere($conditions = [], $column = ['*'], $relation = [], $all = false);
    public function create($payload = []);
    public function createBatch($payload = []);
    public function update($modelId, $payload = []);
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
    public function createPivot($model, $payload = [], $relation = '');
}
