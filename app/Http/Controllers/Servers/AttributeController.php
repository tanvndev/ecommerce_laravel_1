<?php

namespace App\Http\Controllers\Servers;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Attribute\{
    StoreAttributeRequest,
    UpdateAttributeRequest
};

use App\Services\Interfaces\AttributeServiceInterface as AttributeService;
use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;
use App\Repositories\Interfaces\AttributeRepositoryInterface as AttributeRepository;


class AttributeController extends Controller
{
    protected $attributeService;
    protected $attributeRepository;

    // Sử dụng dependency injection chuyển đổi đối tượng của một lớp được đăng ký trong container
    public function __construct(
        AttributeService $attributeService,
        AttributeRepository $attributeRepository,
    ) {
        parent::__construct();
        // Lấy ra ngôn ngữ hiện tại và gán vào session
        $this->middleware(function ($request, $next) {
            $this->initNetedset();
            return $next($request);
        });

        $this->attributeService = $attributeService;
        $this->attributeRepository = $attributeRepository;
    }

    private function initNetedset()
    {
        $this->nestedset = new Nestedsetbie([
            'table' => 'attribute_catalogues',
            'foreignkey' => 'attribute_catalogue_id',
            'language_id' => $this->currentLanguage
        ]);
    }
    //
    function index()
    {
        $this->authorize('modules', 'attribute.index');

        $attributes = $this->attributeService->paginate();
        // dd($attributes);
        $config['seo'] = __('messages.attribute')['index'];

        // Danh mục cha
        $dropdown = $this->nestedset->Dropdown();

        return view('servers.attributes.index', compact([
            'attributes',
            'config',
            'dropdown',
        ]));
    }

    function create()
    {
        $this->authorize('modules', 'attribute.create');

        $config['seo'] = __('messages.attribute')['create'];
        $config['method'] = 'create';
        // Danh mục cha
        $dropdown = $this->nestedset->Dropdown();
        // dd($dropdown);
        return view('servers.attributes.store', compact([
            'config',
            'dropdown',
        ]));
    }

    public function store(StoreAttributeRequest $request)
    {

        $successMessage = $this->getToastMessage('attribute', 'success', 'create');
        $errorMessage = $this->getToastMessage('attribute', 'error', 'create');

        if ($this->attributeService->create()) {
            return redirect()->route('attribute.index')->with('toast_success', $successMessage);
        }
        return redirect()->route('attribute.create')->with('toast_error', $errorMessage);
    }

    public function edit($id)
    {
        $this->authorize('modules', 'attribute.edit');

        // Gán id vào sesson
        session(['_id' => $id]);
        $attribute = $this->attributeRepository->getAttributeLanguageById($id, $this->currentLanguage);
        // dd($attribute);


        $albums =  json_decode($attribute->album);
        // Danh mục cha
        $dropdown = $this->nestedset->Dropdown();
        // dd($attribute);


        $config['seo'] = __('messages.attribute')['update'];
        $config['method'] = 'update';

        return view('servers.attributes.store', compact([
            'config',
            'attribute',
            'albums',
            'dropdown',
        ]));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributeRequest $request, $id)
    {
        $successMessage = $this->getToastMessage('attribute', 'success', 'update');
        $errorMessage = $this->getToastMessage('attribute', 'error', 'update');
        // Lấy giá trị sesson
        $idAttribute = session('_id');
        if (empty($idAttribute)) {
            return redirect()->route('attribute.index')->with('toast_error', $errorMessage);
        }

        if ($this->attributeService->update($idAttribute)) {
            // Xoá giá trị sesson
            session()->forget('_id');
            return redirect()->route('attribute.index')->with('toast_success', $successMessage);
        }
        // Xoá giá trị sesson
        session()->forget('_id');
        return redirect()->route('attribute.edit', $id)->with('toast_error', $errorMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $this->authorize('modules', 'attribute.destroy');

        $successMessage = $this->getToastMessage('attribute', 'success', 'delete');
        $errorMessage = $this->getToastMessage('attribute', 'error', 'delete');

        if ($request->_id == null) {
            return redirect()->route('attribute.index')->with('toast_error', $errorMessage);
        }
        if ($this->attributeService->destroy($request->_id)) {
            return redirect()->route('attribute.index')->with('toast_success', $successMessage);
        }
        return redirect()->route('attribute.index')->with('toast_error', $errorMessage);
    }
}
