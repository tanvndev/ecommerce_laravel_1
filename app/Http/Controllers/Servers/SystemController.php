<?php

namespace App\Http\Controllers\Servers;

use App\Http\Controllers\Controller;
use App\Classes\System;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    protected $systemLibrary;

    public function __construct(System $systemLibrary)
    {
        $this->systemLibrary = $systemLibrary;
    }
    function index()
    {

        $config['seo'] = __('messages.system')['index'];
        $system = $this->systemLibrary->config();


        return view('servers.systems.index', compact([
            'config',
            'system',
        ]));
    }
}
