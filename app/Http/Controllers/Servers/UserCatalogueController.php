<?php

namespace App\Http\Controllers\Servers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\{
    StoreUserCatalogueRequest,
    UpdateUserCatalogueRequest,
};
use App\Services\Interfaces\UserCatalogueServiceInterface as UserCatalogueService;
use App\Repositories\Interfaces\UserCatalogueRepositoryInterface as UserCatalogueRepository;



class UserCatalogueController extends Controller
{
    protected $userCatalogueService;
    protected $userRepository;

    // Sử dụng dependency injection chuyển đổi đối tượng của một lớp được đăng ký trong container
    public function __construct(
        UserCatalogueService $userCatalogueService,
        UserCatalogueRepository $userRepository,
    ) {
        $this->userCatalogueService = $userCatalogueService;
        $this->userRepository = $userRepository;
    }
    //
    function index()
    {
        $userCatalogues = $this->userCatalogueService->paginate();
        $config['seo'] = config('apps.user_catalogue')['index'];

        return view('servers.user_catalogues.index', compact([
            'userCatalogues',
            'config'
        ]));
    }

    function create()
    {
        $config['seo'] = config('apps.user_catalogue')['create'];
        $config['method'] = 'create';
        return view('servers.user_catalogues.store', compact([
            'config',
        ]));
    }

    public function store(StoreUserCatalogueRequest $request)
    {
        // dd($request->all());
        if ($this->userCatalogueService->create()) {
            return redirect()->route('user.catalogue.index')->with('toast_success', 'Tạo nhóm thành viên mới thành công.');
        }
        return redirect()->route('user.catalogue.create')->with('toast_error', 'Có lỗi vui lòng thử lại.');
    }

    public function edit($id)
    {

        // Gán id vào sesson
        session(['_id' => $id]);
        // Lấy ra các tỉnh thành
        $userCatalogue = $this->userRepository->findById($id);
        // dd($user);

        $config['seo'] = config('apps.user_catalogue')['update'];
        $config['method'] = 'update';

        return view('servers.user_catalogues.store', compact([
            'config',
            'userCatalogue',
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserCatalogueRequest $request, $id)
    {
        // Lấy giá trị sesson
        $idUser = session('_id');
        if (empty($idUser)) {
            return redirect()->route('user.catalogue.index')->with('toast_error', 'Có lỗi vui lòng thử lại.');
        }

        if ($this->userCatalogueService->update($idUser)) {
            // Xoá giá trị sesson
            session()->forget('_id');
            return redirect()->route('user.catalogue.index')->with('toast_success', 'Cập nhập thành viên thành công.');
        }
        // Xoá giá trị sesson
        session()->forget('_id');
        return redirect()->route('user.catalogue.create')->with('toast_error', 'Có lỗi vui lòng thử lại.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if ($request->_id == null) {
            return redirect()->route('user.catalogue.index')->with('toast_error', 'Có lỗi vui lòng thử lại');
        }
        if ($this->userCatalogueService->destroy($request->_id)) {

            return redirect()->route('user.catalogue.index')->with('toast_success', 'Xoá thành viên thành công.');
        }
        return redirect()->route('user.catalogue.index')->with('toast_error', 'Có lỗi vui lòng thử lại.');
    }
}
