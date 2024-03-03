<?php

namespace App\Http\Controllers\Servers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function index()
    {

        $title = 'Bảng điều khiển';
        return view('servers.dashboard.index', compact([
            'title'
        ]));
    }
}
