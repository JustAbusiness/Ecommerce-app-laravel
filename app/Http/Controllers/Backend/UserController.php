<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
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

    public function index(Request $request)
    {
        $users = $this->userService->paginate($request);


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

    public function update($id, UpdateUserRequest $request)
    {
        if ($this->userService->update($id,$request)) {
            return redirect()->route('users.update')->with('success', 'Update member successfully!');
        }

        return redirect()->back()->with('error', 'Something went wrong!');
    }

    public function delete($id)
    {
       $user = $this->userRepository->findById($id);
       return view('backend.users.delete', compact('user'));
    }

    public function destroy($id)
    {
        if ($this->userService->delete($id)) {
            return redirect()->route('users.delete')->with('success', 'Delete successfully!');
        }

        return redirect()->back()->with('error', 'Something went wrong!');

    }
}
