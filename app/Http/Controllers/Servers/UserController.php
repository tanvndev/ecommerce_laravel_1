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



class UserController extends Controller
{
    protected $userService;
    protected $provinceRepository;
    protected $userRepository;

    // Sử dụng dependency injection chuyển đổi đối tượng của một lớp được đăng ký trong container
    public function __construct(
        UserService $userService,
        ProvinceRepository $provinceRepository,
        UserRepository $userRepository,
    ) {
        $this->userService = $userService;
        $this->provinceRepository = $provinceRepository;
        $this->userRepository = $userRepository;
    }
    //
    function index()
    {
        $users = $this->userService->paginate();
        $config['seo'] = config('apps.user')['index'];

        return view('servers.users.index', compact([
            'users',
            'config'
        ]));
    }

    function create()
    {
        $provinces = $this->provinceRepository->all();

        $config['seo'] = config('apps.user')['create'];
        $config['method'] = 'create';
        return view('servers.users.store', compact([
            'config',
            'provinces'
        ]));
    }

    public function store(StoreUserRequest $request)
    {
        if ($this->userService->create($request)) {
            return redirect()->route('user.index')->with('toast_success', 'Tạo thành viên mới thành công.');
        }
        return redirect()->route('user.create')->with('toast_error', 'Có lỗi vui lòng thử lại.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        // Gán id vào sesson
        session(['_id' => $id]);
        // Lấy ra các tỉnh thành
        $provinces = $this->provinceRepository->all();
        $user = $this->userRepository->findById($id);
        // dd($user);


        $config['seo'] = config('apps.user')['update'];
        $config['method'] = 'update';

        return view('servers.users.store', compact([
            'config',
            'provinces',
            'user',
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

        if ($this->userService->update($idUser, $request)) {
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
    public function destroy(string $id)
    {
        //
    }
}
