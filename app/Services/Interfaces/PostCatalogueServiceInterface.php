<?php

namespace App\Services\Interfaces;

interface PostCatalogueServiceInterface
{
    public function paginate();
    public function create();
    public function update($id);
    public function destroy($id);
    public function updateStatus();
    public function updateStatusAll();
}
