<?php

namespace App\Services\Interfaces;

interface LanguageServiceInterface
{
    public function paginate();
    public function create();
    public function update($id);
    public function destroy($id);
    public function updateStatus();
    public function updateStatusAll();
    public function switch($id);
    public function saveTranslate($id);
}
