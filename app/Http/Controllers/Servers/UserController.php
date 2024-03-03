<?php

namespace App\Http\Controllers\Servers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\Interfaces\UserServiceInterface as UserService;



class UserController extends Controller
{
    protected $userService;
    // Sử dụng dependency injection chuyển đổi đối tượng của một lớp được đăng ký trong container
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
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
        $config['seo'] = config('apps.user')['create'];
        return view('servers.users.create', compact([
            'config'
        ]));
    }
}
