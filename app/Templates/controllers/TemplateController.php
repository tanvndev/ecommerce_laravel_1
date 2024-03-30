<?php

namespace App\Http\Controllers\Servers;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\{
    Store{ModuleTemplate}Request,
    Update{ModuleTemplate}Request
};

use App\Services\Interfaces\{ModuleTemplate}ServiceInterface as {ModuleTemplate}Service;
use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;
use App\Repositories\Interfaces\{ModuleTemplate}RepositoryInterface as {ModuleTemplate}Repository;


class {ModuleTemplate}Controller extends Controller
{
    protected ${moduleTemplate}Service;
    protected ${moduleTemplate}Repository;

    // Sử dụng dependency injection chuyển đổi đối tượng của một lớp được đăng ký trong container
    public function __construct(
        {ModuleTemplate}Service ${moduleTemplate}Service,
        {ModuleTemplate}Repository ${moduleTemplate}Repository,
    ) {
        // Lấy ra ngôn ngữ hiện tại và gán vào session
        $this->middleware(function ($request, $next) {
            $languageId = app(LanguageRepository::class)->getCurrentLanguage();

            $this->currentLanguage = $languageId;
            session(['currentLanguage' => $languageId]);
            $this->initNetedset();
            return $next($request);
        });

        $this->{moduleTemplate}Service = ${moduleTemplate}Service;
        $this->{moduleTemplate}Repository = ${moduleTemplate}Repository;
    }

    private function initNetedset()
    {
        $this->nestedset = new Nestedsetbie([
            'table' => '{tableName}',
            'foreignkey' => '{foreignKey}',
            'language_id' => $this->currentLanguage
        ]);
    }
    //
    function index()
    {
        $this->authorize('modules', '{moduleTemplate}.index');

        ${moduleTemplate}s = $this->{moduleTemplate}Service->paginate();
        // dd(${moduleTemplate}s);
        $config['seo'] = __('messages.{moduleTemplate}')['index'];

        // Danh mục cha
        $dropdown = $this->nestedset->Dropdown();

        return view('servers.{moduleTemplate}s.index', compact([
            '{moduleTemplate}s',
            'config',
            'dropdown',
        ]));
    }

    function create()
    {
        $this->authorize('modules', '{moduleTemplate}.create');

        $config['seo'] = __('messages.{moduleTemplate}')['create'];
        $config['method'] = 'create';
        // Danh mục cha
        $dropdown = $this->nestedset->Dropdown();
        // dd($dropdown);
        return view('servers.{moduleTemplate}s.store', compact([
            'config',
            'dropdown',
        ]));
    }

    public function store(Store{ModuleTemplate}Request $request)
    {

        $successMessage = $this->getToastMessage('{moduleTemplate}', 'success', 'create');
        $errorMessage = $this->getToastMessage('{moduleTemplate}', 'error', 'create');

        if ($this->{moduleTemplate}Service->create()) {
            return redirect()->route('{moduleTemplate}.index')->with('toast_success', $successMessage);
        }
        return redirect()->route('{moduleTemplate}.create')->with('toast_error', $errorMessage);
    }

    public function edit($id)
    {
        $this->authorize('modules', '{moduleTemplate}.edit');

        // Gán id vào sesson
        session(['_id' => $id]);
        ${moduleTemplate} = $this->{moduleTemplate}Repository->get{ModuleTemplate}LanguageById($id, $this->currentLanguage);
        // dd(${moduleTemplate});


        $albums =  json_decode(${moduleTemplate}->album);
        // Danh mục cha
        $dropdown = $this->nestedset->Dropdown();
        // dd(${moduleTemplate});


        $config['seo'] = __('messages.{moduleTemplate}')['update'];
        $config['method'] = 'update';

        return view('servers.{moduleTemplate}s.store', compact([
            'config',
            '{moduleTemplate}',
            'albums',
            'dropdown',
        ]));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Update{ModuleTemplate}Request $request, $id)
    {
        $successMessage = $this->getToastMessage('{moduleTemplate}', 'success', 'update');
        $errorMessage = $this->getToastMessage('{moduleTemplate}', 'error', 'update');
        // Lấy giá trị sesson
        $id{ModuleTemplate} = session('_id');
        if (empty($id{ModuleTemplate})) {
            return redirect()->route('{moduleTemplate}.index')->with('toast_error', $errorMessage);
        }

        if ($this->{moduleTemplate}Service->update($id{ModuleTemplate})) {
            // Xoá giá trị sesson
            session()->forget('_id');
            return redirect()->route('{moduleTemplate}.index')->with('toast_success', $successMessage);
        }
        // Xoá giá trị sesson
        session()->forget('_id');
        return redirect()->route('{moduleTemplate}.edit', $id)->with('toast_error', $errorMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $this->authorize('modules', '{moduleTemplate}.destroy');

        $successMessage = $this->getToastMessage('{moduleTemplate}', 'success', 'delete');
        $errorMessage = $this->getToastMessage('{moduleTemplate}', 'error', 'delete');

        if ($request->_id == null) {
            return redirect()->route('{moduleTemplate}.index')->with('toast_error', $errorMessage);
        }
        if ($this->{moduleTemplate}Service->destroy($request->_id)) {
            return redirect()->route('{moduleTemplate}.index')->with('toast_success', $successMessage);
        }
        return redirect()->route('{moduleTemplate}.index')->with('toast_error', $errorMessage);
    }
}
