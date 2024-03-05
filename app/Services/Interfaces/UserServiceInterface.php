<?php

namespace App\Services\Interfaces;

interface UserServiceInterface
{
    public function paginate();
    public function create($request);
    public function update($id, $request);
}
