<?php

namespace App\Services\Interfaces;

interface ProductCatalogueServiceInterface
{
    public function paginate();
    public function create();
    public function update($id);
    public function destroy($id);
    public function updateStatus();
    public function updateStatusAll();
    public function setAttribute($product);
    public function getFilterList($attribute);
}
