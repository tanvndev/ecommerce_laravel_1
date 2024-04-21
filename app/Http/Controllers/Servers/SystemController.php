<?php

namespace App\Http\Controllers\Servers;

use App\Http\Controllers\Controller;
use App\Classes\System;
use App\Services\Interfaces\SystemServiceInterface as SystemService;

use Illuminate\Http\Request;

class SystemController extends Controller
{
    protected $systemLibrary;
    protected $systemService;

    public function __construct(
        System $systemLibrary,
        SystemService $systemService
    ) {
        parent::__construct();
        $this->systemLibrary = $systemLibrary;
        $this->systemService = $systemService;
    }
    public function index()
    {
        $this->authorize('modules', 'system.index');
        $config['seo'] = __('messages.system')['index'];
        $systemConfig = $this->systemLibrary->config();
        $systems = $this->systemService->getAll();
        // dd($systems);
        return view('servers.systems.index', compact([
            'config',
            'systemConfig',
            'systems',
        ]));
    }

    public function store(Request $request)
    {
        $successMessage = $this->getToastMessage('system', 'success', 'update');
        $errorMessage = $this->getToastMessage('system', 'error', 'update');

        if ($this->systemService->save()) {
            return redirect()->route('system.index')->with('toast_success', $successMessage);
        }

        return redirect()->route('system.index')->with('toast_error', $errorMessage);
    }
}
