<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CommentRepositoryInterface as CommentRepository;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface as ProductCatalogueRepository;
use App\Repositories\Interfaces\ProductRepositoryInterface as ProductRepository;
use App\Services\Interfaces\CommentServiceInterface as CommentService;
use App\Services\Interfaces\ProductServiceInterface as ProductService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productRepository;
    private $productService;
    private $productCatalogueRepository;
    private $commentService;
    private $commentRepository;

    public function __construct(
        ProductRepository $productRepository,
        ProductService $productService,
        ProductCatalogueRepository $productCatalogueRepository,
        CommentService $commentService,
        CommentRepository $commentRepository
    ) {
        parent::__construct();
        $this->productRepository = $productRepository;
        $this->productService = $productService;
        $this->productCatalogueRepository = $productCatalogueRepository;
        $this->commentService = $commentService;
        $this->commentRepository = $commentRepository;
    }

    public function index($id)
    {
        $product = $this->productRepository->getProductLanguageById($id, session('currentLanguage', 1));
        $product = $this->productService->combineProductAndPromotion([$id], $product, true);
        $user = Auth::user() ?? null;
        $productCatalogue = $this->productCatalogueRepository->getProductCatalogueLanguageById($product->product_catalogue_id, session('currentLanguage', 1));

        // dd($product);

        // Neu co bien the san pham thi lay bien the
        if (!is_null($product->attribute)) {
            $product = $this->productService->getAttribute($product);
        }

        $breadcrumb = $this->productCatalogueRepository->breadcrumb($productCatalogue, session('currentLanguage', 1));
        $seo = seo($product);
        return view('clients.products.index', compact(
            'seo',
            'breadcrumb',
            'productCatalogue',
            'product',
            'user',
        ));
    }
}
