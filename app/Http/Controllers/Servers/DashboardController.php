<?php

namespace App\Http\Controllers\Servers;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    function index()
    {

        $config['seo'] = __('messages.dashboard')['index'];
        return view('servers.dashboard.index', compact([
            'config'
        ]));
    }
}
