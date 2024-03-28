<?php

namespace App\Services\Interfaces;

interface GenerateServiceInterface
{
    public function paginate();
    public function create();
    public function update($id);
    public function destroy($id);
}
