<?php

namespace App\Http\Controllers\Servers;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\{
    StoreProductCatalogueRequest,
    UpdateProductCatalogueRequest,
    DeleteProductCatalogueRequest
};
use App\Services\Interfaces\ProductCatalogueServiceInterface as ProductCatalogueService;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface as ProductCatalogueRepository;



class ProductCatalogueController extends Controller
{
    protected $productCatalogueService;
    protected $productCatalogueRepository;

    // Sử dụng dependency injection chuyển đổi đối tượng của một lớp được đăng ký trong container
    public function __construct(
        ProductCatalogueService $productCatalogueService,
        ProductCatalogueRepository $productCatalogueRepository,
    ) {
        parent::__construct();

        // Lấy ra ngôn ngữ hiện tại và gán vào session
        $this->middleware(function ($request, $next) {
            $this->initNetedset();
            return $next($request);
        });

        $this->productCatalogueService = $productCatalogueService;
        $this->productCatalogueRepository = $productCatalogueRepository;
    }

    private function initNetedset()
    {
        $this->nestedset = new Nestedsetbie([
            'table' => 'product_catalogues',
            'foreignkey' => 'product_catalogue_id',
            'language_id' => $this->currentLanguage
        ]);
    }
    //
    public function index()
    {
        $this->authorize('modules', 'product.catalogue.index');

        $productCatalogues = $this->productCatalogueService->paginate();
        $config['seo'] = __('messages.productCatalogue')['index'];


        return view('servers.product_catalogues.index', compact([
            'productCatalogues',
            'config'
        ]));
    }

    public function create()
    {
        $this->authorize('modules', 'product.catalogue.create');

        $config['seo'] = __('messages.productCatalogue')['create'];
        $config['method'] = 'create';
        // Danh mục cha
        $dropdown = $this->nestedset->Dropdown();
        // dd($dropdown);
        return view('servers.product_catalogues.store', compact([
            'config',
            'dropdown',
        ]));
    }

    public function store(StoreProductCatalogueRequest $request)
    {

        $successMessage = $this->getToastMessage('productCatalogue', 'success', 'create');
        $errorMessage = $this->getToastMessage('productCatalogue', 'error', 'create');

        if ($this->productCatalogueService->create()) {
            return redirect()->route('product.catalogue.index')->with('toast_success', $successMessage);
        }
        return redirect()->route('product.catalogue.create')->with('toast_error', $errorMessage);
    }

    public function edit($id)
    {
        $this->authorize('modules', 'product.catalogue.edit');

        // Gán id vào sesson
        session(['_id' => $id]);
        $productCatalogue = $this->productCatalogueRepository->getProductCatalogueLanguageById($id, $this->currentLanguage);

        $albums =  json_decode($productCatalogue->album);
        // Danh mục cha
        $dropdown = $this->nestedset->Dropdown();
        // dd($productCatalogue);


        $config['seo'] = __('messages.productCatalogue')['update'];
        $config['method'] = 'update';

        return view('servers.product_catalogues.store', compact([
            'config',
            'productCatalogue',
            'albums',
            'dropdown',
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductCatalogueRequest $request, $id)
    {

        $successMessage = $this->getToastMessage('productCatalogue', 'success', 'update');
        $errorMessage = $this->getToastMessage('productCatalogue', 'error', 'update');

        // Lấy giá trị sesson
        $idProductCatalogue = session('_id');
        if (empty($idProductCatalogue)) {
            return redirect()->route('product.catalogue.index')->with('toast_error', $errorMessage);
        }

        if ($this->productCatalogueService->update($idProductCatalogue)) {
            // Xoá giá trị sesson
            session()->forget('_id');
            return redirect()->route('product.catalogue.index')->with('toast_success', $successMessage);
        }
        // Xoá giá trị sesson
        session()->forget('_id');
        return redirect()->route('product.catalogue.edit', $id)->with('toast_error', $errorMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteProductCatalogueRequest $request)
    {
        $this->authorize('modules', 'product.catalogue.destroy');

        $successMessage = $this->getToastMessage('productCatalogue', 'success', 'delete');
        $errorMessage = $this->getToastMessage('productCatalogue', 'error', 'delete');

        if ($request->_id == null) {
            return redirect()->route('product.catalogue.index')->with('toast_error', $errorMessage);
        }
        if ($this->productCatalogueService->destroy($request->_id)) {
            return redirect()->route('product.catalogue.index')->with('toast_success', $successMessage);
        }
        return redirect()->route('product.catalogue.index')->with('toast_error', $errorMessage);
    }
}
