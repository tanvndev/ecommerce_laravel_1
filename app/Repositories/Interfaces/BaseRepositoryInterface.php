<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    public function all();
    public function findById($modelId, $column = ['*'], $relation = []);
    public function create($payload = []);
    public function update($modelId, $payload = []);
    public function updateByWhereIn($whereInField = '', $whereIn = [], $payload = []);
    public function delete($modelId);
    public function forceDelete($modelId);
    public function pagination(
        $column = ['*'],
        $condition = [],
        $join = [],
        $perPage = 20,
        $relations = []
    );
    public function createLanguagePivot($model, $payload = []);
}
