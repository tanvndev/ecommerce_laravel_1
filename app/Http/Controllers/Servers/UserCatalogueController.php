<?php

namespace App\Http\Controllers\Servers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\{
    StoreUserCatalogueRequest,
    UpdateUserCatalogueRequest,
};
use App\Services\Interfaces\UserCatalogueServiceInterface as UserCatalogueService;
use App\Repositories\Interfaces\UserCatalogueRepositoryInterface as UserCatalogueRepository;
use App\Repositories\Interfaces\PermissionRepositoryInterface as PermissionRepository;




class UserCatalogueController extends Controller
{
    protected $userCatalogueService;
    protected $userCatalogueRepository;
    protected $permissionRepository;


    // Sử dụng dependency injection chuyển đổi đối tượng của một lớp được đăng ký trong container
    public function __construct(
        UserCatalogueService $userCatalogueService,
        UserCatalogueRepository $userCatalogueRepository,
        PermissionRepository $permissionRepository

    ) {
        $this->userCatalogueService = $userCatalogueService;
        $this->userCatalogueRepository = $userCatalogueRepository;
        $this->permissionRepository = $permissionRepository;
    }
    //
    function index()
    {
        $this->authorize('modules', 'user.catalogue.index');

        $userCatalogues = $this->userCatalogueService->paginate();
        $config['seo'] = __('messages.userCatalogue')['index'];

        return view('servers.user_catalogues.index', compact([
            'userCatalogues',
            'config'
        ]));
    }

    function create()
    {
        $this->authorize('modules', 'user.catalogue.create');

        $config['seo'] = __('messages.userCatalogue')['create'];
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
        $this->authorize('modules', 'user.catalogue.edit');

        // Gán id vào sesson
        session(['_id' => $id]);
        // Lấy ra các tỉnh thành
        $userCatalogue = $this->userCatalogueRepository->findById($id);
        // dd($user);

        $config['seo'] = __('messages.userCatalogue')['update'];
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
        $this->authorize('modules', 'user.catalogue.destroy');

        if ($request->_id == null) {
            return redirect()->route('user.catalogue.index')->with('toast_error', 'Có lỗi vui lòng thử lại');
        }
        if ($this->userCatalogueService->destroy($request->_id)) {

            return redirect()->route('user.catalogue.index')->with('toast_success', 'Xoá thành viên thành công.');
        }
        return redirect()->route('user.catalogue.index')->with('toast_error', 'Có lỗi vui lòng thử lại.');
    }

    public function permission()
    {
        $userCatalogues = $this->userCatalogueRepository->all(['permissions']);
        $permissions = $this->permissionRepository->all();

        $config['seo'] = __('messages.userCatalogue')['permission'];

        return view('servers.user_catalogues.permission', compact([
            'config',
            'userCatalogues',
            'permissions',
        ]));
    }
    public function updatePermission(Request $request)
    {
        if ($this->userCatalogueService->setPermission()) {
            return redirect()->route('user.catalogue.permission')->with('toast_success', 'Cập nhập quyền thành công.');
        }
        return redirect()->route('user.catalogue.permission')->with('toast_error', 'Cập nhập quyền thất bại.');
    }
}
