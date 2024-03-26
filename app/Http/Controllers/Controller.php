<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    protected $currentLanguage;

    public function __construct()
    {
        $this->currentLanguage = app()->getLocale();
    }

    public function currentLanguage()
    {
        return 1;
    }

    protected function getLanguageMessage()
    {
        return __('messages.language');
    }


    protected function getPermissionMessage($key, $action)
    {
        $configMessage = __('messages.permission.' . $action);
        return $configMessage[$key] ?? null;
    }
}
