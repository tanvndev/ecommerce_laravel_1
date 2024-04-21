<?php

namespace App\Http\Controllers\Servers;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Source\{
    StoreSourceRequest,
    UpdateSourceRequest
};


use App\Services\Interfaces\SourceServiceInterface as SourceService;
use App\Repositories\Interfaces\SourceRepositoryInterface as SourceRepository;


class SourceController extends Controller
{
    protected $sourceService;
    protected $sourceRepository;

    // Sử dụng dependency injection chuyển đổi đối tượng của một lớp được đăng ký trong container
    public function __construct(
        SourceService $sourceService,
        SourceRepository $sourceRepository,
    ) {
        parent::__construct();
        // Khởi tạo new Nestedsetbie
        $this->middleware(function ($request, $next) {
            $this->initNetedset();
            return $next($request);
        });

        $this->sourceService = $sourceService;
        $this->sourceRepository = $sourceRepository;
    }

    private function initNetedset()
    {
        $this->nestedset = new Nestedsetbie([
            'table' => 'source_catalogues',
            'foreignkey' => 'source_catalogue_id',
            'language_id' => $this->currentLanguage
        ]);
    }
    //
    function index()
    {
        $this->authorize('modules', 'source.index');

        $sources = $this->sourceService->paginate();
        // dd($sources);
        $config['seo'] = __('messages.source')['index'];

        // Danh mục cha
        $dropdown = $this->nestedset->Dropdown();

        return view('servers.sources.index', compact([
            'sources',
            'config',
            'dropdown',
        ]));
    }

    function create()
    {
        $this->authorize('modules', 'source.create');

        $config['seo'] = __('messages.source')['create'];
        $config['method'] = 'create';
        // Danh mục cha
        $dropdown = $this->nestedset->Dropdown();
        // dd($dropdown);
        return view('servers.sources.store', compact([
            'config',
            'dropdown',
        ]));
    }

    public function store(StoreSourceRequest $request)
    {

        $successMessage = $this->getToastMessage('source', 'success', 'create');
        $errorMessage = $this->getToastMessage('source', 'error', 'create');

        if ($this->sourceService->create()) {
            return redirect()->route('source.index')->with('toast_success', $successMessage);
        }
        return redirect()->route('source.create')->with('toast_error', $errorMessage);
    }

    public function edit($id)
    {
        $this->authorize('modules', 'source.edit');

        // Gán id vào sesson
        session(['_id' => $id]);
        $source = $this->sourceRepository->getSourceLanguageById($id, $this->currentLanguage);
        // dd($source);


        $albums =  json_decode($source->album);
        // Danh mục cha
        $dropdown = $this->nestedset->Dropdown();
        // dd($source);


        $config['seo'] = __('messages.source')['update'];
        $config['method'] = 'update';

        return view('servers.sources.store', compact([
            'config',
            'source',
            'albums',
            'dropdown',
        ]));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSourceRequest $request, $id)
    {
        $successMessage = $this->getToastMessage('source', 'success', 'update');
        $errorMessage = $this->getToastMessage('source', 'error', 'update');
        // Lấy giá trị sesson
        $idSource = session('_id');
        if (empty($idSource)) {
            return redirect()->route('source.index')->with('toast_error', $errorMessage);
        }

        if ($this->sourceService->update($idSource)) {
            // Xoá giá trị sesson
            session()->forget('_id');
            return redirect()->route('source.index')->with('toast_success', $successMessage);
        }
        // Xoá giá trị sesson
        session()->forget('_id');
        return redirect()->route('source.edit', $id)->with('toast_error', $errorMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $this->authorize('modules', 'source.destroy');

        $successMessage = $this->getToastMessage('source', 'success', 'delete');
        $errorMessage = $this->getToastMessage('source', 'error', 'delete');

        if ($request->_id == null) {
            return redirect()->route('source.index')->with('toast_error', $errorMessage);
        }
        if ($this->sourceService->destroy($request->_id)) {
            return redirect()->route('source.index')->with('toast_success', $successMessage);
        }
        return redirect()->route('source.index')->with('toast_error', $errorMessage);
    }
}
