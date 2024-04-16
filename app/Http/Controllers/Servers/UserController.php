<?php

namespace App\Http\Controllers\Servers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\{
    StoreUserRequest,
    UpdateUserRequest,
};

use App\Services\Interfaces\UserServiceInterface as UserService;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
use App\Repositories\Interfaces\UserCatalogueRepositoryInterface as UserCatalogueRepository;



class UserController extends Controller
{
    protected $userService;
    protected $provinceRepository;
    protected $userRepository;
    protected $userCatalogueRepository;

    // Sử dụng dependency injection chuyển đổi đối tượng của một lớp được đăng ký trong container
    public function __construct(
        UserService $userService,
        ProvinceRepository $provinceRepository,
        UserRepository $userRepository,
        UserCatalogueRepository $userCatalogueRepository,
    ) {
        $this->userService = $userService;
        $this->provinceRepository = $provinceRepository;
        $this->userRepository = $userRepository;
        $this->userCatalogueRepository = $userCatalogueRepository;
    }
    //
    function index()
    {
        $this->authorize('modules', 'user.index');


        $users = $this->userService->paginate();
        $userCatalogues = $this->userCatalogueRepository->all();
        $config['seo'] = __('messages.user')['index'];



        return view('servers.users.index', compact([
            'users',
            'config',
            'userCatalogues'
        ]));
    }

    function create()
    {
        $this->authorize('modules', 'user.create');

        $provinces = $this->provinceRepository->all();
        $userCatalogues = $this->userCatalogueRepository->all();

        $config['seo'] = __('messages.user')['create'];
        $config['method'] = 'create';
        return view('servers.users.store', compact([
            'config',
            'provinces',
            'userCatalogues'
        ]));
    }

    public function store(StoreUserRequest $request)
    {
        if ($this->userService->create()) {
            return redirect()->route('user.index')->with('toast_success', 'Tạo thành viên mới thành công.');
        }
        return redirect()->route('user.create')->with('toast_error', 'Có lỗi vui lòng thử lại.');
    }


    public function edit($id)
    {
        $this->authorize('modules', 'user.edit');

        // Gán id vào sesson
        session(['_id' => $id]);
        // Lấy ra các tỉnh thành
        $provinces = $this->provinceRepository->all();
        $userCatalogue = $this->userCatalogueRepository->all();
        $user = $this->userRepository->findById($id);
        // dd($user);


        $config['seo'] = __('messages.user')['update'];
        $config['method'] = 'update';

        return view('servers.users.store', compact([
            'config',
            'provinces',
            'user',
            'userCatalogue',
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $id)
    {
        // Lấy giá trị sesson
        $idUser = session('_id');
        if (empty($idUser)) {
            return redirect()->route('user.index')->with('toast_error', 'Có lỗi vui lòng thử lại.');
        }

        if ($this->userService->update($idUser)) {
            // Xoá giá trị sesson
            session()->forget('_id');
            return redirect()->route('user.index')->with('toast_success', 'Cập nhập thành viên thành công.');
        }
        // Xoá giá trị sesson
        session()->forget('_id');
        return redirect()->route('user.create')->with('toast_error', 'Có lỗi vui lòng thử lại.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $this->authorize('modules', 'user.destroy');

        if ($request->_id == null) {
            return redirect()->route('user.index')->with('toast_error', 'Có lỗi vui lòng thử lại');
        }
        if ($this->userService->destroy($request->_id)) {

            return redirect()->route('user.index')->with('toast_success', 'Xoá thành viên thành công.');
        }
        return redirect()->route('user.index')->with('toast_error', 'Có lỗi vui lòng thử lại.');
    }
}
