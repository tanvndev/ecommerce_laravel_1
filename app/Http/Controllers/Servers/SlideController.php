<?php

namespace App\Http\Controllers\Servers;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\{
    StoreSlideRequest,
    UpdateSlideRequest
};

use App\Services\Interfaces\SlideServiceInterface as SlideService;
use App\Repositories\Interfaces\SlideRepositoryInterface as SlideRepository;


class SlideController extends Controller
{
    protected $slideService;
    protected $slideRepository;

    // Sử dụng dependency injection chuyển đổi đối tượng của một lớp được đăng ký trong container
    public function __construct(
        SlideService $slideService,
        SlideRepository $slideRepository,
    ) {
        parent::__construct();
        // Khởi tạo new Nestedsetbie
        $this->middleware(function ($request, $next) {
            $this->initNetedset();
            return $next($request);
        });

        $this->slideService = $slideService;
        $this->slideRepository = $slideRepository;
    }

    private function initNetedset()
    {
        $this->nestedset = new Nestedsetbie([
            'table' => 'slide_catalogues',
            'foreignkey' => 'slide_catalogue_id',
            'language_id' => $this->currentLanguage
        ]);
    }
    //
    function index()
    {
        $this->authorize('modules', 'slide.index');

        $slides = $this->slideService->paginate();
        // dd($slides);
        $config['seo'] = __('messages.slide')['index'];


        return view('servers.slides.index', compact([
            'slides',
            'config',
        ]));
    }

    function create()
    {
        $this->authorize('modules', 'slide.create');

        $config['seo'] = __('messages.slide')['create'];
        $config['method'] = 'create';
        // Danh mục cha
        $dropdown = $this->nestedset->Dropdown();
        // dd($dropdown);
        return view('servers.slides.store', compact([
            'config',
            'dropdown',
        ]));
    }

    public function store(StoreSlideRequest $request)
    {

        $successMessage = $this->getToastMessage('slide', 'success', 'create');
        $errorMessage = $this->getToastMessage('slide', 'error', 'create');

        if ($this->slideService->create()) {
            return redirect()->route('slide.index')->with('toast_success', $successMessage);
        }
        return redirect()->route('slide.create')->with('toast_error', $errorMessage);
    }

    public function edit($id)
    {
        $this->authorize('modules', 'slide.edit');

        // Gán id vào sesson
        session(['_id' => $id]);
        $slide = $this->slideRepository->getSlideLanguageById($id, $this->currentLanguage);
        // dd($slide);


        $albums =  json_decode($slide->album);
        // Danh mục cha
        $dropdown = $this->nestedset->Dropdown();
        // dd($slide);


        $config['seo'] = __('messages.slide')['update'];
        $config['method'] = 'update';

        return view('servers.slides.store', compact([
            'config',
            'slide',
            'albums',
            'dropdown',
        ]));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSlideRequest $request, $id)
    {
        $successMessage = $this->getToastMessage('slide', 'success', 'update');
        $errorMessage = $this->getToastMessage('slide', 'error', 'update');
        // Lấy giá trị sesson
        $idSlide = session('_id');
        if (empty($idSlide)) {
            return redirect()->route('slide.index')->with('toast_error', $errorMessage);
        }

        if ($this->slideService->update($idSlide)) {
            // Xoá giá trị sesson
            session()->forget('_id');
            return redirect()->route('slide.index')->with('toast_success', $successMessage);
        }
        // Xoá giá trị sesson
        session()->forget('_id');
        return redirect()->route('slide.edit', $id)->with('toast_error', $errorMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $this->authorize('modules', 'slide.destroy');

        $successMessage = $this->getToastMessage('slide', 'success', 'delete');
        $errorMessage = $this->getToastMessage('slide', 'error', 'delete');

        if ($request->_id == null) {
            return redirect()->route('slide.index')->with('toast_error', $errorMessage);
        }
        if ($this->slideService->destroy($request->_id)) {
            return redirect()->route('slide.index')->with('toast_success', $successMessage);
        }
        return redirect()->route('slide.index')->with('toast_error', $errorMessage);
    }
}
