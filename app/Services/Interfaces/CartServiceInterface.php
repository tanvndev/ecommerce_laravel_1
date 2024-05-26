<?php

namespace App\Services\Interfaces;

/**
 * Interface CartServiceInterface
 * @package App\Services\Interfaces
 */
interface CartServiceInterface
{
    public function create();
    public function update($id);
    public function destroy($id);
}
