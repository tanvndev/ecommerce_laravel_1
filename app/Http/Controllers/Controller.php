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

    protected function getToastMessage($module, $key, $action)
    {
        $configMessage = __("messages.$module.$action");
        return $configMessage[$key] ?? null;
    }
}
