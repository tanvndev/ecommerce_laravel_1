<?php

namespace App\Http\Controllers\Servers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\{
    StoreLanguageRequest,
    UpdateLanguageRequest,
    UpdateTranslateRequest,
};

use App\Services\Interfaces\LanguageServiceInterface as LanguageService;
use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;

class LanguageController extends Controller
{
    protected $languageService;
    protected $languageRepository;

    // Sử dụng dependency injection chuyển đổi đối tượng của một lớp được đăng ký trong container
    public function __construct(
        LanguageService $languageService,
        LanguageRepository $languageRepository,
    ) {
        parent::__construct();
        $this->languageService = $languageService;
        $this->languageRepository = $languageRepository;
    }
    //
    function index()
    {
        $this->authorize('modules', 'language.index');

        $languagesData = $this->languageService->paginate();
        // dd($languages);
        $config['seo'] = __('messages.language')['index'];
        return view('servers.languages.index', compact([
            'languagesData',
            'config'
        ]));
    }

    function create()
    {
        $this->authorize('modules', 'language.create');

        $config['seo'] = __('messages.language')['create'];
        $config['method'] = 'create';
        return view('servers.languages.store', compact([
            'config',
        ]));
    }

    public function store(StoreLanguageRequest $request)
    {
        $successMessage = 'Thành công';
        $errorMessage = 'Thất bại';

        if ($this->languageService->create()) {
            return redirect()->route('language.index')->with('toast_success', $successMessage);
        }

        return redirect()->route('language.create')->with('toast_error', $errorMessage);
    }

    public function edit($id)
    {
        $this->authorize('modules', 'language.edit');

        // Gán id vào sesson
        session(['_id' => $id]);
        $language = $this->languageRepository->findById($id);
        // dd($language);


        $config['seo'] = __('messages.language')['update'];
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
        $successMessage = $this->getLanguageMessage('success', 'update');
        $errorMessage = $this->getLanguageMessage('error', 'update');

        // Lấy giá trị sesson
        $idLanguage = session('_id');
        if (empty($idLanguage)) {
            return redirect()->route('language.index')->with('toast_error', $errorMessage);
        }

        if ($this->languageService->update($idLanguage)) {
            // Xoá giá trị sesson
            session()->forget('_id');
            return redirect()->route('language.index')->with('toast_success',  $successMessage);
        }
        // Xoá giá trị sesson
        session()->forget('_id');
        return redirect()->route('language.create')->with('toast_error', $errorMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $this->authorize('modules', 'language.destroy');
        $successMessage = $this->getLanguageMessage('success', 'delete');
        $errorMessage = $this->getLanguageMessage('error', 'delete');

        if ($request->_id == null) {
            return redirect()->route('language.index')->with('toast_error', $errorMessage);
        }
        if ($this->languageService->destroy($request->_id)) {
            return redirect()->route('language.index')->with('toast_success',  $successMessage);
        }
        return redirect()->route('language.index')->with('toast_error', $errorMessage);
    }

    public function switchServerLanguage($canonical)
    {
        $successMessage = $this->getLanguageMessage('success', 'index');
        $errorMessage = $this->getLanguageMessage('error', 'index');

        if ($this->languageService->switch($canonical)) {
            // Lưu giá trị 'locale' vào session để giữ trạng thái ngôn ngữ khi người dùng truy cập các trang khác rồi sẽ dùng middleware để xử lý ngôn ngữ
            session(['locale' => $canonical]);

            return redirect()->back()->with('toast_success', $successMessage);
        }
        return redirect()->back()->with('toast_error', $errorMessage);
    }

    public function translate($id, $languageId, $modelName = '')
    {
        $this->authorize('modules', 'language.translate');

        // Lây ra repository hiện tại
        $repositoryInstance = $this->getRepositoryInstance($modelName);
        // Lấy ra ngôn ngữ hiện tại
        $currentLanguage = $this->languageRepository->findByWhere(['canonical' => ['=', app()->getLocale()]]);

        // Lấy ra bản dịch hiện tại
        $methodName = 'get' . ucfirst($modelName) . 'LanguageById';
        $modelObject = $repositoryInstance->{$methodName}($id, $currentLanguage->id);

        // Lấy ra bản dịch ngôn ngữ muốn dịch
        $modelObjectTranslate = $repositoryInstance->{$methodName}($id, $languageId);


        $config['seo'] = __('messages.language')['update'];
        $option = [
            'languageId' => $languageId,
            'model' => $modelName
        ];

        return view('servers.languages.translate', compact([
            'config',
            'modelObject',
            'modelObjectTranslate',
            'option'
        ]));
    }

    public function handleTranslate(UpdateTranslateRequest $request, $id)
    {
        $successMessage = "Thành công";
        $errorMessage = "Thất bại";


        if ($this->languageService->saveTranslate($id)) {
            return redirect()->back()->with('toast_success',  $successMessage);
        }

        return redirect()->back()->with('toast_error', $errorMessage);
    }
    private function getRepositoryInstance($modelName)
    {
        $repositoryInterfaceNameSpace = 'App\Repositories\Interfaces\\' . ucfirst($modelName) . 'RepositoryInterface';
        if (interface_exists($repositoryInterfaceNameSpace)) {
            // hàm app() giúp truy cập các đối tượng đã đăng ký trong container
            return app($repositoryInterfaceNameSpace);
        }
        return null;
    }
}
