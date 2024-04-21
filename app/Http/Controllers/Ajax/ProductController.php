<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productRepository;
    protected $productCatalogueService;
    protected $productService;
    public function __construct()
    {
        parent::__construct();
    }


    public function loadProductPromotion(Request $request)
    {
        $modelName = $request->model;
        $condition = [
            'tb2.language_id' => ['=', session('currentLanguage')],
        ];
        if (isset($request->keyword) && !empty($request->keyword)) {
            $condition = [
                'tb2.name' => ['like', '%' . $request->keyword . '%'],
            ];
        }

        $repositoryInstance = $this->getRepositoryInstance($modelName);
        if ($modelName == 'Product') {
            $data = $repositoryInstance->findProductForPromotion($condition, ['languages']);
        } else if ($modelName == 'ProductCatalogue') {

            $condition = [
                'keyword' => addslashes(request('keyword')),
                'where' => [
                    'tb2.language_id' => ['=', session('currentLanguage')]
                ]
            ];
            $join = [
                'product_catalogue_language as tb2' => ['tb2.product_catalogue_id', '=', 'product_catalogues.id']
            ];

            //////////////////////////////////////////////////////////
            $data = $repositoryInstance->pagination(
                ['product_catalogues.id', 'tb2.name'],
                $condition,
                10,
                ['product_catalogues.id' => 'desc'],
                $join,
            );
        }

        // dd($data);
        return response()->json([
            'model' => $modelName,
            'data' => $data
        ]);
    }
}
