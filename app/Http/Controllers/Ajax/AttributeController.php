<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AttributeRepositoryInterface as AttributeRepository;
use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;
use Illuminate\Http\Request;


class AttributeController extends Controller
{
    protected $attributeRepository;
    public function __construct(
        AttributeRepository $attributeRepository,
    ) {
        // Lấy ra ngôn ngữ hiện tại và gán vào session
        $this->middleware(function ($request, $next) {
            $languageId = app(LanguageRepository::class)->getCurrentLanguage();

            $this->currentLanguage = $languageId;
            session(['currentLanguage' => $languageId]);
            return $next($request);
        });
        $this->attributeRepository = $attributeRepository;
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

        return response()->json(['items' => $attributeMapped]);
    }
}
