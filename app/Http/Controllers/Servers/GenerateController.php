<?php

namespace App\Http\Controllers\Servers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\{
    StoreGenerateRequest,
    UpdateGenerateRequest,
    UpdateTranslateRequest,
};

use App\Services\Interfaces\GenerateServiceInterface as GenerateService;
use App\Repositories\Interfaces\GenerateRepositoryInterface as GenerateRepository;

class GenerateController extends Controller
{
    protected $generateService;
    protected $generateRepository;

    // Sử dụng dependency injection chuyển đổi đối tượng của một lớp được đăng ký trong container
    public function __construct(
        GenerateService $generateService,
        GenerateRepository $generateRepository,
    ) {
        parent::__construct();
        $this->generateService = $generateService;
        $this->generateRepository = $generateRepository;
    }
    //
    function index()
    {
        $this->authorize('modules', 'generate.index');

        $generates = $this->generateService->paginate();
        // dd($generates);
        $config['seo'] = __('messages.generate')['index'];
        return view('servers.generates.index', compact([
            'generates',
            'config'
        ]));
    }

    function create()
    {
        $this->authorize('modules', 'generate.create');

        $config['seo'] = __('messages.generate')['create'];
        $config['method'] = 'create';
        return view('servers.generates.store', compact([
            'config',
        ]));
    }

    public function store(StoreGenerateRequest $request)
    {
        $successMessage = $this->getToastMessage('generate', 'success', 'create');
        $errorMessage = $this->getToastMessage('generate', 'error', 'create');

        if ($this->generateService->create()) {
            return redirect()->route('generate.index')->with('toast_success', $successMessage);
        }

        return redirect()->route('generate.create')->with('toast_error', $errorMessage);
    }

    public function edit($id)
    {
        $this->authorize('modules', 'generate.edit');

        // Gán id vào sesson
        session(['_id' => $id]);
        $generate = $this->generateRepository->findById($id);
        // dd($generate);


        $config['seo'] = __('messages.generate')['update'];
        $config['method'] = 'update';

        return view('servers.generates.store', compact([
            'config',
            'generate',
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGenerateRequest $request, $id)
    {
        $successMessage = $this->getToastMessage('generate', 'success', 'update');
        $errorMessage = $this->getToastMessage('generate', 'error', 'update');

        // Lấy giá trị sesson
        $idGenerate = session('_id');
        if (empty($idGenerate)) {
            return redirect()->route('generate.index')->with('toast_error', $errorMessage);
        }

        if ($this->generateService->update($idGenerate)) {
            // Xoá giá trị sesson
            session()->forget('_id');
            return redirect()->route('generate.index')->with('toast_success',  $successMessage);
        }
        // Xoá giá trị sesson
        session()->forget('_id');
        return redirect()->route('generate.create')->with('toast_error', $errorMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $this->authorize('modules', 'generate.destroy');
        $successMessage = $this->getToastMessage('generate', 'success', 'delete');
        $errorMessage = $this->getToastMessage('generate', 'error', 'delete');

        if ($request->_id == null) {
            return redirect()->route('generate.index')->with('toast_error', $errorMessage);
        }
        if ($this->generateService->destroy($request->_id)) {
            return redirect()->route('generate.index')->with('toast_success',  $successMessage);
        }
        return redirect()->route('generate.index')->with('toast_error', $errorMessage);
    }
}
