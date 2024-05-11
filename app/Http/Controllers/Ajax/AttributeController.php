<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AttributeRepositoryInterface as AttributeRepository;
use Illuminate\Http\Request;


class AttributeController extends Controller
{
    protected $attributeRepository;
    public function __construct()
    {
        // Lấy ra ngôn ngữ hiện tại và gán vào session
        parent::__construct();
        $this->attributeRepository = app(AttributeRepository::class);
    }

    public function getAttribute(Request $request)
    {
        $attributes = $this->attributeRepository->searchAttributes($request['search'], $request['option'], $this->currentLanguage);

        $attributeMapped = $attributes->map(function ($attribute) {
            return [
                'id' => $attribute->id,
                'text' => $attribute->attribute_language->first()->name
            ];
        });

        return response()->json(array('items' => $attributeMapped));
    }

    public function loadAttribute(Request $request)
    {
        // dd($request->all());
        $payload['attribute'] = $request->attribute;
        $payload['attributeCatalogueId'] = $request->attributeCatalogueId;

        $attributeArray = $request->attribute[$request->attributeCatalogueId];
        if (!empty($attributeArray)) {
            $attribute = $this->attributeRepository->findAttributeByIdArray($attributeArray, $this->currentLanguage);
        }

        $variants = [];
        if (!empty($attribute)) {
            foreach ($attribute as $value) {
                $variants[] = [
                    'id' => $value->id,
                    'text' => $value->attribute_language->first()->name
                ];
            }
        }
        return response()->json($variants);
    }
}
