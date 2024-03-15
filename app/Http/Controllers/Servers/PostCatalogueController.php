<?php

namespace App\Http\Controllers\Servers;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\{
    StorePostCatalogueRequest,
    UpdatePostCatalogueRequest,
};

use App\Services\Interfaces\PostCatalogueServiceInterface as PostCatalogueService;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;



class PostCatalogueController extends Controller
{
    protected $postCatalogueService;
    protected $postCatalogueRepository;
    protected $nestedset;

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
            'language_id' => 1
        ]);
    }
    //
    function index()
    {
        $postCatalogues = $this->postCatalogueService->paginate();
        // dd($postCatalogues);
        $config['seo'] = config('apps.post_catalogue')['index'];


        return view('servers.post_catalogues.index', compact([
            'postCatalogues',
            'config'
        ]));
    }

    function create()
    {
        $config['seo'] = config('apps.post_catalogue')['create'];
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
        $postCatalogue = $this->postCatalogueRepository->findById($id);
        // dd($postCatalogue);


        $config['seo'] = config('apps.post_catalogue')['update'];
        $config['method'] = 'update';

        return view('servers.post_catalogues.store', compact([
            'config',
            'postCatalogue',
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
        return redirect()->route('post.catalogue.create')->with('toast_error', 'Có lỗi vui lòng thử lại.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
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
