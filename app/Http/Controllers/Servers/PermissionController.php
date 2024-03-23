<?php

namespace App\Http\Controllers\Servers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\{
    StorePermissionRequest,
    UpdatePermissionRequest,
};

use App\Services\Interfaces\PermissionServiceInterface as PermissionService;
use App\Repositories\Interfaces\PermissionRepositoryInterface as PermissionRepository;

class PermissionController extends Controller
{
    protected $permissionService;
    protected $permissionRepository;

    // Sử dụng dependency injection chuyển đổi đối tượng của một lớp được đăng ký trong container
    public function __construct(
        PermissionService $permissionService,
        PermissionRepository $permissionRepository,
    ) {
        $this->permissionService = $permissionService;
        $this->permissionRepository = $permissionRepository;
    }
    //
    function index()
    {
        $this->authorize('modules', 'permission.index');


        $permissions = $this->permissionService->paginate();
        // dd($permissions);
        $config['seo'] = __('messages.permission')['index'];
        return view('servers.permissions.index', compact([
            'permissions',
            'config'
        ]));
    }

    function create()
    {
        $this->authorize('modules', 'permission.create');

        $config['seo'] = __('messages.permission')['create'];
        $config['method'] = 'create';
        return view('servers.permissions.store', compact([
            'config',
        ]));
    }

    public function store(StorePermissionRequest $request)
    {
        $successMessage = $this->getPermissionMessage('success', 'create');
        $errorMessage = $this->getPermissionMessage('error', 'create');

        if ($this->permissionService->create()) {
            return redirect()->route('permission.index')->with('toast_success', $successMessage);
        }

        return redirect()->route('permission.create')->with('toast_error', $errorMessage);
    }

    public function edit($id)
    {
        $this->authorize('modules', 'permission.edit');

        // Gán id vào sesson
        session(['_id' => $id]);
        $permission = $this->permissionRepository->findById($id);
        // dd($permission);


        $config['seo'] = __('messages.permission')['update'];
        $config['method'] = 'update';

        return view('servers.permissions.store', compact([
            'config',
            'permission',
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, $id)
    {
        $successMessage = $this->getPermissionMessage('success', 'update');
        $errorMessage = $this->getPermissionMessage('error', 'update');

        // Lấy giá trị sesson
        $idPermission = session('_id');
        if (empty($idPermission)) {
            return redirect()->route('permission.index')->with('toast_error', $errorMessage);
        }

        if ($this->permissionService->update($idPermission)) {
            // Xoá giá trị sesson
            session()->forget('_id');
            return redirect()->route('permission.index')->with('toast_success',  $successMessage);
        }
        // Xoá giá trị sesson
        session()->forget('_id');
        return redirect()->route('permission.create')->with('toast_error', $errorMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $this->authorize('modules', 'permission.destroy');

        $successMessage = $this->getPermissionMessage('success', 'delete');
        $errorMessage = $this->getPermissionMessage('error', 'delete');

        if ($request->_id == null) {
            return redirect()->route('permission.index')->with('toast_error', $errorMessage);
        }
        if ($this->permissionService->destroy($request->_id)) {
            return redirect()->route('permission.index')->with('toast_success',  $successMessage);
        }
        return redirect()->route('permission.index')->with('toast_error', $errorMessage);
    }



    public function switchServerPermission($canonical)
    {
        $successMessage = $this->getPermissionMessage('success', 'index');
        $errorMessage = $this->getPermissionMessage('error', 'index');

        if ($this->permissionService->switch($canonical)) {
            // Lưu giá trị 'locale' vào session để giữ trạng thái ngôn ngữ khi người dùng truy cập các trang khác rồi sẽ dùng middleware để xử lý ngôn ngữ
            session(['locale' => $canonical]);

            return redirect()->back()->with('toast_success', $successMessage);
        }
        return redirect()->back()->with('toast_error', $errorMessage);
    }
}
