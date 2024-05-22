<?php

namespace App\Services\Interfaces;

interface WidgetServiceInterface
{
    public function paginate();
    public function create();
    public function update($id);
    public function destroy($id);
    public function updateStatus();
    public function updateStatusAll();
    public function saveTranslate();
    public function getWidget($params = []);
}
