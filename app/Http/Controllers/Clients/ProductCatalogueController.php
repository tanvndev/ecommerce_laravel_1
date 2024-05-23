<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface as ProductCatalogueRepository;
use Illuminate\Http\Request;

class ProductCatalogueController extends Controller
{
    private $productCatalogueRepository;
    public function __construct()
    {
        parent::__construct();
        $this->productCatalogueRepository = app(ProductCatalogueRepository::class);
    }
    public function index($id)
    {
        $productCatalogue = $this->productCatalogueRepository->getProductCatalogueLanguageById($id, $this->currentLanguage);

        $seo = seo($productCatalogue);

        return view('clients.product_catalogues.index', compact(
            'productCatalogue',
            'seo'
        ));
    }
}
