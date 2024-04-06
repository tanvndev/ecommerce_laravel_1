<?php

namespace App\Http\Controllers\Servers;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\{
    StoreProductRequest,
    UpdateProductRequest
};
use App\Repositories\Interfaces\AttributeCatalogueRepositoryInterface as AttributeCatalogueRepository;
use App\Services\Interfaces\ProductServiceInterface as ProductService;
use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;
use App\Repositories\Interfaces\ProductRepositoryInterface as ProductRepository;


class ProductController extends Controller
{
    protected $productService;
    protected $productRepository;
    protected $attributeCatalogueRepository;

    // Sử dụng dependency injection chuyển đổi đối tượng của một lớp được đăng ký trong container
    public function __construct(
        ProductService $productService,
        ProductRepository $productRepository,
        AttributeCatalogueRepository $attributeCatalogueRepository,
    ) {
        // Lấy ra ngôn ngữ hiện tại và gán vào session
        $this->middleware(function ($request, $next) {
            $languageId = app(LanguageRepository::class)->getCurrentLanguage();

            $this->currentLanguage = $languageId;
            session(['currentLanguage' => $languageId]);
            $this->initNetedset();
            return $next($request);
        });

        $this->productService = $productService;
        $this->productRepository = $productRepository;
        $this->attributeCatalogueRepository = $attributeCatalogueRepository;
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
    function index()
    {
        $this->authorize('modules', 'product.index');

        $products = $this->productService->paginate();
        // dd($products);
        $config['seo'] = __('messages.product')['index'];

        // Danh mục cha
        $dropdown = $this->nestedset->Dropdown();

        return view('servers.products.index', compact([
            'products',
            'config',
            'dropdown',
        ]));
    }

    function create()
    {
        $this->authorize('modules', 'product.create');

        $config['seo'] = __('messages.product')['create'];
        $config['method'] = 'create';
        // Danh mục cha
        $dropdown = $this->nestedset->Dropdown();

        $attributeCatalogues = $this->attributeCatalogueRepository->getAll($this->currentLanguage);
        // dd($dropdown);
        return view('servers.products.store', compact([
            'config',
            'dropdown',
            'attributeCatalogues'
        ]));
    }

    public function store(StoreProductRequest $request)
    {

        $successMessage = $this->getToastMessage('product', 'success', 'create');
        $errorMessage = $this->getToastMessage('product', 'error', 'create');

        if ($this->productService->create()) {
            return redirect()->route('product.index')->with('toast_success', $successMessage);
        }
        return redirect()->route('product.create')->with('toast_error', $errorMessage);
    }

    public function edit($id)
    {
        $this->authorize('modules', 'product.edit');

        // Gán id vào sesson
        session(['_id' => $id]);
        $product = $this->productRepository->getProductLanguageById($id, $this->currentLanguage);
        // dd($product);

        $attributeCatalogues = $this->attributeCatalogueRepository->getAll($this->currentLanguage);

        $albums =  json_decode($product->album);
        // Danh mục cha
        $dropdown = $this->nestedset->Dropdown();
        // dd($product);


        $config['seo'] = __('messages.product')['update'];
        $config['method'] = 'update';

        return view('servers.products.store', compact([
            'config',
            'product',
            'albums',
            'attributeCatalogues',
            'dropdown',
        ]));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $successMessage = $this->getToastMessage('product', 'success', 'update');
        $errorMessage = $this->getToastMessage('product', 'error', 'update');
        // Lấy giá trị sesson
        $idProduct = session('_id');
        if (empty($idProduct)) {
            return redirect()->route('product.index')->with('toast_error', $errorMessage);
        }

        if ($this->productService->update($idProduct)) {
            // Xoá giá trị sesson
            session()->forget('_id');
            return redirect()->route('product.index')->with('toast_success', $successMessage);
        }
        // Xoá giá trị sesson
        session()->forget('_id');
        return redirect()->route('product.edit', $id)->with('toast_error', $errorMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $this->authorize('modules', 'product.destroy');

        $successMessage = $this->getToastMessage('product', 'success', 'delete');
        $errorMessage = $this->getToastMessage('product', 'error', 'delete');

        if ($request->_id == null) {
            return redirect()->route('product.index')->with('toast_error', $errorMessage);
        }
        if ($this->productService->destroy($request->_id)) {
            return redirect()->route('product.index')->with('toast_success', $successMessage);
        }
        return redirect()->route('product.index')->with('toast_error', $errorMessage);
    }
}
