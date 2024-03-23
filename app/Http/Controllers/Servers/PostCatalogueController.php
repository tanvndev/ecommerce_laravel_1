<?php

namespace App\Http\Controllers\Servers;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use App\Http\Requests\{
    StorePostCatalogueRequest,
    UpdatePostCatalogueRequest,
    DeletePostCatalogueRequest
};

use App\Services\Interfaces\PostCatalogueServiceInterface as PostCatalogueService;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;



class PostCatalogueController extends Controller
{
    protected $postCatalogueService;
    protected $postCatalogueRepository;
    protected $nestedset;
    protected $currentLanguage;


    // Sử dụng dependency injection chuyển đổi đối tượng của một lớp được đăng ký trong container
    public function __construct(
        PostCatalogueService $postCatalogueService,
        PostCatalogueRepository $postCatalogueRepository,
    ) {
        $this->postCatalogueService = $postCatalogueService;
        $this->postCatalogueRepository = $postCatalogueRepository;
        $this->nestedset = new Nestedsetbie([
            'table' => 'post_catalogues',
            'foreignkey' => 'post_catalogue_id',
            'language_id' => $this->currentLanguage()
        ]);
        $this->currentLanguage = $this->currentLanguage();
    }
    //
    function index()
    {
        $postCatalogues = $this->postCatalogueService->paginate();
        $config['seo'] = __('messages.postCatalogue')['index'];


        return view('servers.post_catalogues.index', compact([
            'postCatalogues',
            'config'
        ]));
    }

    function create()
    {
        $config['seo'] = __('messages.postCatalogue')['create'];
        $config['method'] = 'create';
        // Danh mục cha
        $dropdown = $this->nestedset->Dropdown();
        // dd($dropdown);
        return view('servers.post_catalogues.store', compact([
            'config',
            'dropdown',
        ]));
    }

    public function store(StorePostCatalogueRequest $request)
    {
        if ($this->postCatalogueService->create()) {
            return redirect()->route('post.catalogue.index')->with('toast_success', 'Tạo nhóm bài viết mới thành công.');
        }
        return redirect()->route('post.catalogue.create')->with('toast_error', 'Có lỗi vui lòng thử lại.');
    }

    public function edit($id)
    {

        // Gán id vào sesson
        session(['_id' => $id]);
        $postCatalogue = $this->postCatalogueRepository->getPostCatalogueLanguageById($id, $this->currentLanguage());

        $albums =  json_decode($postCatalogue->album);
        // Danh mục cha
        $dropdown = $this->nestedset->Dropdown();
        // dd($postCatalogue);


        $config['seo'] = __('messages.postCatalogue')['update'];
        $config['method'] = 'update';

        return view('servers.post_catalogues.store', compact([
            'config',
            'postCatalogue',
            'albums',
            'dropdown',
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostCatalogueRequest $request, $id)
    {
        // Lấy giá trị sesson
        $idPostCatalogue = session('_id');
        if (empty($idPostCatalogue)) {
            return redirect()->route('post.catalogue.index')->with('toast_error', 'Có lỗi vui lòng thử lại.');
        }

        if ($this->postCatalogueService->update($idPostCatalogue)) {
            // Xoá giá trị sesson
            session()->forget('_id');
            return redirect()->route('post.catalogue.index')->with('toast_success', 'Cập nhập nhóm bài viết thành công.');
        }
        // Xoá giá trị sesson
        session()->forget('_id');
        return redirect()->route('post.catalogue.edit', $id)->with('toast_error', 'Có lỗi vui lòng thử lại.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeletePostCatalogueRequest $request)
    {
        if ($request->_id == null) {
            return redirect()->route('post.catalogue.index')->with('toast_error', 'Có lỗi vui lòng thử lại');
        }
        if ($this->postCatalogueService->destroy($request->_id)) {
            return redirect()->route('post.catalogue.index')->with('toast_success', 'Xoá nhóm bài viết thành công.');
        }
        return redirect()->route('post.catalogue.index')->with('toast_error', 'Có lỗi vui lòng thử lại.');
    }
}
