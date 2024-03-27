<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $currentLanguage;
    protected $nestedset;

    public function __construct()
    {
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
