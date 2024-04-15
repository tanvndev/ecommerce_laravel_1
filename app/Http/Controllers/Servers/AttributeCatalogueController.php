<?php

namespace App\Http\Controllers\Servers;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use App\Http\Requests\{
    StoreAttributeCatalogueRequest,
    UpdateAttributeCatalogueRequest,
    DeleteAttributeCatalogueRequest
};
use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;
use App\Services\Interfaces\AttributeCatalogueServiceInterface as AttributeCatalogueService;
use App\Repositories\Interfaces\AttributeCatalogueRepositoryInterface as AttributeCatalogueRepository;



class AttributeCatalogueController extends Controller
{
    protected $attributeCatalogueService;
    protected $attributeCatalogueRepository;

    // Sử dụng dependency injection chuyển đổi đối tượng của một lớp được đăng ký trong container
    public function __construct(
        AttributeCatalogueService $attributeCatalogueService,
        AttributeCatalogueRepository $attributeCatalogueRepository,
    ) {
        parent::__construct();

        // Khởi tạo new Nestedsetbie
        $this->middleware(function ($request, $next) {
            $this->initNetedset();
            return $next($request);
        });

        $this->attributeCatalogueService = $attributeCatalogueService;
        $this->attributeCatalogueRepository = $attributeCatalogueRepository;
    }

    private function initNetedset()
    {
        $this->nestedset = new Nestedsetbie([
            'table' => 'attribute_catalogues',
            'foreignkey' => 'attribute_catalogue_id',
            'language_id' => $this->currentLanguage
        ]);
    }
    //
    public function index()
    {
        $this->authorize('modules', 'attribute.catalogue.index');

        $attributeCatalogues = $this->attributeCatalogueService->paginate();
        $config['seo'] = __('messages.attributeCatalogue')['index'];


        return view('servers.attribute_catalogues.index', compact([
            'attributeCatalogues',
            'config'
        ]));
    }

    public function create()
    {
        $this->authorize('modules', 'attribute.catalogue.create');

        $config['seo'] = __('messages.attributeCatalogue')['create'];
        $config['method'] = 'create';
        // Danh mục cha
        $dropdown = $this->nestedset->Dropdown();
        // dd($dropdown);
        return view('servers.attribute_catalogues.store', compact([
            'config',
            'dropdown',
        ]));
    }

    public function store(StoreAttributeCatalogueRequest $request)
    {

        $successMessage = $this->getToastMessage('attributeCatalogue', 'success', 'create');
        $errorMessage = $this->getToastMessage('attributeCatalogue', 'error', 'create');

        if ($this->attributeCatalogueService->create()) {
            return redirect()->route('attribute.catalogue.index')->with('toast_success', $successMessage);
        }
        return redirect()->route('attribute.catalogue.create')->with('toast_error', $errorMessage);
    }

    public function edit($id)
    {
        $this->authorize('modules', 'attribute.catalogue.edit');

        // Gán id vào sesson
        session(['_id' => $id]);
        $attributeCatalogue = $this->attributeCatalogueRepository->getAttributeCatalogueLanguageById($id, $this->currentLanguage);

        $albums =  json_decode($attributeCatalogue->album);
        // Danh mục cha
        $dropdown = $this->nestedset->Dropdown();
        // dd($attributeCatalogue);


        $config['seo'] = __('messages.attributeCatalogue')['update'];
        $config['method'] = 'update';

        return view('servers.attribute_catalogues.store', compact([
            'config',
            'attributeCatalogue',
            'albums',
            'dropdown',
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributeCatalogueRequest $request, $id)
    {

        $successMessage = $this->getToastMessage('attributeCatalogue', 'success', 'update');
        $errorMessage = $this->getToastMessage('attributeCatalogue', 'error', 'update');

        // Lấy giá trị sesson
        $idAttributeCatalogue = session('_id');
        if (empty($idAttributeCatalogue)) {
            return redirect()->route('attribute.catalogue.index')->with('toast_error', $errorMessage);
        }

        if ($this->attributeCatalogueService->update($idAttributeCatalogue)) {
            // Xoá giá trị sesson
            session()->forget('_id');
            return redirect()->route('attribute.catalogue.index')->with('toast_success', $successMessage);
        }
        // Xoá giá trị sesson
        session()->forget('_id');
        return redirect()->route('attribute.catalogue.edit', $id)->with('toast_error', $errorMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteAttributeCatalogueRequest $request)
    {
        $this->authorize('modules', 'attribute.catalogue.destroy');

        $successMessage = $this->getToastMessage('attributeCatalogue', 'success', 'delete');
        $errorMessage = $this->getToastMessage('attributeCatalogue', 'error', 'delete');

        if ($request->_id == null) {
            return redirect()->route('attribute.catalogue.index')->with('toast_error', $errorMessage);
        }
        if ($this->attributeCatalogueService->destroy($request->_id)) {
            return redirect()->route('attribute.catalogue.index')->with('toast_success', $successMessage);
        }
        return redirect()->route('attribute.catalogue.index')->with('toast_error', $errorMessage);
    }
}
