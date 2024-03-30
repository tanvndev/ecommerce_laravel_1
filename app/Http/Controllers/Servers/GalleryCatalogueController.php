<?php

namespace App\Http\Controllers\Servers;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use App\Http\Requests\{
    StoreGalleryCatalogueRequest,
    UpdateGalleryCatalogueRequest,
    DeleteGalleryCatalogueRequest
};
use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;
use App\Services\Interfaces\GalleryCatalogueServiceInterface as GalleryCatalogueService;
use App\Repositories\Interfaces\GalleryCatalogueRepositoryInterface as GalleryCatalogueRepository;



class GalleryCatalogueController extends Controller
{
    protected $galleryCatalogueService;
    protected $galleryCatalogueRepository;

    // Sử dụng dependency injection chuyển đổi đối tượng của một lớp được đăng ký trong container
    public function __construct(
        GalleryCatalogueService $galleryCatalogueService,
        GalleryCatalogueRepository $galleryCatalogueRepository,
    ) {
        parent::__construct();

        // Lấy ra ngôn ngữ hiện tại và gán vào session
        $this->middleware(function ($request, $next) {
            $languageId = app(LanguageRepository::class)->getCurrentLanguage();

            $this->currentLanguage = $languageId;
            session(['currentLanguage' => $languageId]);
            $this->initNetedset();
            return $next($request);
        });

        $this->galleryCatalogueService = $galleryCatalogueService;
        $this->galleryCatalogueRepository = $galleryCatalogueRepository;
    }

    private function initNetedset()
    {
        $this->nestedset = new Nestedsetbie([
            'table' => 'gallery_catalogues',
            'foreignkey' => 'gallery_catalogue_id',
            'language_id' => $this->currentLanguage
        ]);
    }
    //
    public function index()
    {
        $this->authorize('modules', 'gallery.catalogue.index');

        $galleryCatalogues = $this->galleryCatalogueService->paginate();
        $config['seo'] = __('messages.galleryCatalogue')['index'];


        return view('servers.gallery_catalogues.index', compact([
            'galleryCatalogues',
            'config'
        ]));
    }

    public function create()
    {
        $this->authorize('modules', 'gallery.catalogue.create');

        $config['seo'] = __('messages.galleryCatalogue')['create'];
        $config['method'] = 'create';
        // Danh mục cha
        $dropdown = $this->nestedset->Dropdown();
        // dd($dropdown);
        return view('servers.gallery_catalogues.store', compact([
            'config',
            'dropdown',
        ]));
    }

    public function store(StoreGalleryCatalogueRequest $request)
    {

        $successMessage = $this->getToastMessage('galleryCatalogue', 'success', 'create');
        $errorMessage = $this->getToastMessage('galleryCatalogue', 'error', 'create');

        if ($this->galleryCatalogueService->create()) {
            return redirect()->route('gallery.catalogue.index')->with('toast_success', $successMessage);
        }
        return redirect()->route('gallery.catalogue.create')->with('toast_error', $errorMessage);
    }

    public function edit($id)
    {
        $this->authorize('modules', 'gallery.catalogue.edit');

        // Gán id vào sesson
        session(['_id' => $id]);
        $galleryCatalogue = $this->galleryCatalogueRepository->getGalleryCatalogueLanguageById($id, $this->currentLanguage);

        $albums =  json_decode($galleryCatalogue->album);
        // Danh mục cha
        $dropdown = $this->nestedset->Dropdown();
        // dd($galleryCatalogue);


        $config['seo'] = __('messages.galleryCatalogue')['update'];
        $config['method'] = 'update';

        return view('servers.gallery_catalogues.store', compact([
            'config',
            'galleryCatalogue',
            'albums',
            'dropdown',
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGalleryCatalogueRequest $request, $id)
    {

        $successMessage = $this->getToastMessage('galleryCatalogue', 'success', 'update');
        $errorMessage = $this->getToastMessage('galleryCatalogue', 'error', 'update');

        // Lấy giá trị sesson
        $idGalleryCatalogue = session('_id');
        if (empty($idGalleryCatalogue)) {
            return redirect()->route('gallery.catalogue.index')->with('toast_error', $errorMessage);
        }

        if ($this->galleryCatalogueService->update($idGalleryCatalogue)) {
            // Xoá giá trị sesson
            session()->forget('_id');
            return redirect()->route('gallery.catalogue.index')->with('toast_success', $successMessage);
        }
        // Xoá giá trị sesson
        session()->forget('_id');
        return redirect()->route('gallery.catalogue.edit', $id)->with('toast_error', $errorMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteGalleryCatalogueRequest $request)
    {
        $this->authorize('modules', 'gallery.catalogue.destroy');

        $successMessage = $this->getToastMessage('galleryCatalogue', 'success', 'delete');
        $errorMessage = $this->getToastMessage('galleryCatalogue', 'error', 'delete');

        if ($request->_id == null) {
            return redirect()->route('gallery.catalogue.index')->with('toast_error', $errorMessage);
        }
        if ($this->galleryCatalogueService->destroy($request->_id)) {
            return redirect()->route('gallery.catalogue.index')->with('toast_success', $successMessage);
        }
        return redirect()->route('gallery.catalogue.index')->with('toast_error', $errorMessage);
    }
}
