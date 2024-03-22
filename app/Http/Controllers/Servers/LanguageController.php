<?php

namespace App\Http\Controllers\Servers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\{
    StoreLanguageRequest,
    UpdateLanguageRequest,
};

use App\Services\Interfaces\LanguageServiceInterface as LanguageService;
use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;
use Illuminate\Support\Facades\Config;

class LanguageController extends Controller
{
    protected $languageService;
    protected $languageRepository;

    // Sử dụng dependency injection chuyển đổi đối tượng của một lớp được đăng ký trong container
    public function __construct(
        LanguageService $languageService,
        LanguageRepository $languageRepository,
    ) {
        $this->languageService = $languageService;
        $this->languageRepository = $languageRepository;
    }
    //
    function index()
    {
        $languages = $this->languageService->paginate();
        // dd($languages);
        $config['seo'] = config('apps.language')['index'];


        return view('servers.languages.index', compact([
            'languages',
            'config'
        ]));
    }

    function create()
    {
        $config['seo'] = config('apps.language')['create'];
        $config['method'] = 'create';
        return view('servers.languages.store', compact([
            'config',
        ]));
    }

    public function store(StoreLanguageRequest $request)
    {
        if ($this->languageService->create()) {
            return redirect()->route('language.index')->with('toast_success', 'Tạo ngôn ngữ mới thành công.');
        }
        return redirect()->route('language.create')->with('toast_error', 'Có lỗi vui lòng thử lại.');
    }

    public function edit($id)
    {

        // Gán id vào sesson
        session(['_id' => $id]);
        $language = $this->languageRepository->findById($id);
        // dd($language);


        $config['seo'] = config('apps.language')['update'];
        $config['method'] = 'update';

        return view('servers.languages.store', compact([
            'config',
            'language',
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLanguageRequest $request, $id)
    {
        // Lấy giá trị sesson
        $idLanguage = session('_id');
        if (empty($idLanguage)) {
            return redirect()->route('language.index')->with('toast_error', 'Có lỗi vui lòng thử lại.');
        }

        if ($this->languageService->update($idLanguage)) {
            // Xoá giá trị sesson
            session()->forget('_id');
            return redirect()->route('language.index')->with('toast_success', 'Cập nhập ngôn ngữ thành công.');
        }
        // Xoá giá trị sesson
        session()->forget('_id');
        return redirect()->route('language.create')->with('toast_error', 'Có lỗi vui lòng thử lại.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if ($request->_id == null) {
            return redirect()->route('language.index')->with('toast_error', 'Có lỗi vui lòng thử lại');
        }
        if ($this->languageService->destroy($request->_id)) {
            return redirect()->route('language.index')->with('toast_success', 'Xoá ngôn ngữ thành công.');
        }
        return redirect()->route('language.index')->with('toast_error', 'Có lỗi vui lòng thử lại.');
    }

    public function switchServerLanguage($canonical)
    {
        if ($this->languageService->switch($canonical)) {
            // Lưu giá trị 'locale' vào session để giữ trạng thái ngôn ngữ khi người dùng truy cập các trang khác rồi sẽ dùng middleware để xử lý ngôn ngữ
            session(['locale' => $canonical]);

            return redirect()->back()->with('toast_success', 'Thay đổi ngôn ngữ thành công.');
        }
        return redirect()->back()->with('toast_error', 'Có lỗi vui lòng thử lại.');
    }
}
