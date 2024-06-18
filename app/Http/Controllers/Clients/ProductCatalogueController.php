<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface as ProductCatalogueRepository;
use App\Services\Interfaces\ProductServiceInterface as ProductService;

use App\Services\Interfaces\ProductCatalogueServiceInterface as ProductCatalogueService;


use Illuminate\Http\Request;

class ProductCatalogueController extends Controller
{
    private $productCatalogueRepository;
    private $productService;
    private $productCatalogueService;
    public function __construct(
        ProductCatalogueRepository $productCatalogueRepository,
        ProductService $productService,
        ProductCatalogueService $productCatalogueService

    ) {
        parent::__construct();
        $this->productCatalogueRepository = $productCatalogueRepository;
        $this->productService = $productService;
        $this->productCatalogueService = $productCatalogueService;
    }
    public function index($id)
    {
        $productCatalogue = $this->productCatalogueRepository->getProductCatalogueLanguageById($id, session('currentLanguage', 1));

        $filters = $this->productCatalogueService->getFilterList($productCatalogue->attribute);
        // dd($filters);
        $breadcrumb = $this->productCatalogueRepository->breadcrumb($productCatalogue, session('currentLanguage', 1));
        $products = $this->productService->paginate($productCatalogue);
        $productId = $products->pluck('id')->toArray();
        if (count($productId) > 0) {
            $products = $this->productService->combineProductAndPromotion($productId, $products);
        }
        $seo = seo($productCatalogue);

        return view('clients.product_catalogues.index', compact(
            'seo',
            'breadcrumb',
            'productCatalogue',
            'products',
            'filters'
        ));
    }
}
