<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AttributeCatalogueRepositoryInterface as AttributeCatalogueRepository;
use App\Repositories\Interfaces\ProductVariantRepositoryInterface as ProductVariantRepository;
use App\Repositories\Interfaces\PromotionRepositoryInterface as PromotionRepository;
use App\Services\Interfaces\PromotionServiceInterface as PromotionService;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productVariantRepository;
    protected $attributeCatalogueRepository;
    protected $promotionRepository;

    public function __construct(
        ProductVariantRepository $productVariantRepository,
        PromotionRepository $promotionRepository,
        AttributeCatalogueRepository $attributeCatalogueRepository
    ) {
        parent::__construct();
        $this->productVariantRepository = $productVariantRepository;
        $this->promotionRepository = $promotionRepository;
        $this->attributeCatalogueRepository = $attributeCatalogueRepository;
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

    public function loadVariant(Request $request)
    {
        $attributeId = $request->input('attribute_id');

        sort($attributeId, SORT_NUMERIC);
        $attributeId = implode(', ', $attributeId);

        $variant = $this->productVariantRepository->findVariant($attributeId, $request->product_id);

        $variantPromotion = $this->promotionRepository->findPromotionProductVariant($variant->uuid);
        $variantPrice = getVariantPrice($variant, $variantPromotion);
        $variant->promotion = $variantPrice ?? null;

        return response()->json($variant);
    }
}
