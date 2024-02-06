<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Interfaces\UserServiceInterface as UserService;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceService;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;

class UserController extends Controller
{
    protected $userService;
    protected $provinceRepository;
    protected $userRepository;

    public function __constructor(UserService $userService, ProvinceService $provinceRepository, UserRepository $userRepository)
    {
        $this->userService = $userService;
        $this->provinceRepository = $provinceRepository;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userService->paginate();


        return view('backend.users.index', compact('users'));
    }

    public function create()
    {
        $location = [
            'province' => $this->provinceRepository->all()
        ];

        return view('backedn.users.create', compact('location'));
    }

    public function store(StoreUserRequest $request)
    {
        if ($this->userService->create($request)) {
            return redirect()->route('users.index')->with('success', 'Create new member successfully!');
        }

        return redirect()->back()->with('error', 'Something went wrong!');
    }

    public function edit($id)
    {
        $user = $this->userRepository->findById($id);
        $province = $this->provinceRepository->all();

        return view('backend.users.edit', compact('user', 'province'));
    }
}
