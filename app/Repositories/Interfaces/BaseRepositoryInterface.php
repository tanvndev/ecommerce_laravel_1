<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    public function all();
    public function findById($modelId, $column = ['*'], $relation = []);
    public function create($payload = []);
    public function update($modelId, $payload = []);
}
