<?php

namespace App\Http\Controllers\Servers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Promotion\{
    StorePromotionRequest,
    UpdatePromotionRequest
};
use App\Models\Source;
use App\Services\Interfaces\PromotionServiceInterface as PromotionService;
use App\Repositories\Interfaces\PromotionRepositoryInterface as PromotionRepository;
use App\Repositories\Interfaces\SourceRepositoryInterface as SourceRepository;

class PromotionController extends Controller
{
    protected $promotionService;
    protected $sourceRepository;
    protected $promotionRepository;

    // Sử dụng dependency injection chuyển đổi đối tượng của một lớp được đăng ký trong container
    public function __construct(
        PromotionService $promotionService,
        PromotionRepository $promotionRepository,
        SourceRepository $sourceRepository,
    ) {
        parent::__construct();
        // Khởi tạo new Nestedsetbie
        $this->middleware(function ($request, $next) {
            return $next($request);
        });

        $this->promotionService = $promotionService;
        $this->promotionRepository = $promotionRepository;
        $this->sourceRepository = $sourceRepository;
    }


    function index()
    {
        $this->authorize('modules', 'promotion.index');

        $promotions = $this->promotionService->paginate();
        // dd($promotions);
        $config['seo'] = __('messages.promotion')['index'];


        return view('servers.promotions.index', compact([
            'promotions',
            'config',
        ]));
    }

    function create()
    {
        $this->authorize('modules', 'promotion.create');

        $config['seo'] = __('messages.promotion')['create'];
        $config['method'] = 'create';
        $sources = $this->sourceRepository->all();
        return view('servers.promotions.store', compact([
            'config',
            'sources'
        ]));
    }

    public function store(StorePromotionRequest $request)
    {
        dd($request->all());
        // $successMessage = $this->getToastMessage('promotion', 'success', 'create');
        // $errorMessage = $this->getToastMessage('promotion', 'error', 'create');

        // if ($this->promotionService->create()) {
        //     return redirect()->route('promotion.index')->with('toast_success', $successMessage);
        // }
        // return redirect()->route('promotion.create')->with('toast_error', $errorMessage);
    }

    public function edit($id)
    {
        $this->authorize('modules', 'promotion.edit');

        // Gán id vào sesson
        session(['_id' => $id]);
        $promotion = [];
        // dd($promotion);


        $albums =  json_decode($promotion ?? '');

        $config['seo'] = __('messages.promotion')['update'];
        $config['method'] = 'update';

        return view('servers.promotions.store', compact([
            'config',
            'promotion',
        ]));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePromotionRequest $request, $id)
    {
        $successMessage = $this->getToastMessage('promotion', 'success', 'update');
        $errorMessage = $this->getToastMessage('promotion', 'error', 'update');
        // Lấy giá trị sesson
        $idPromotion = session('_id');
        if (empty($idPromotion)) {
            return redirect()->route('promotion.index')->with('toast_error', $errorMessage);
        }

        if ($this->promotionService->update($idPromotion)) {
            // Xoá giá trị sesson
            session()->forget('_id');
            return redirect()->route('promotion.index')->with('toast_success', $successMessage);
        }
        // Xoá giá trị sesson
        session()->forget('_id');
        return redirect()->route('promotion.edit', $id)->with('toast_error', $errorMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $this->authorize('modules', 'promotion.destroy');

        $successMessage = $this->getToastMessage('promotion', 'success', 'delete');
        $errorMessage = $this->getToastMessage('promotion', 'error', 'delete');

        if ($request->_id == null) {
            return redirect()->route('promotion.index')->with('toast_error', $errorMessage);
        }
        if ($this->promotionService->destroy($request->_id)) {
            return redirect()->route('promotion.index')->with('toast_success', $successMessage);
        }
        return redirect()->route('promotion.index')->with('toast_error', $errorMessage);
    }
}
