<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserCatalogueRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserCatalogueRepository;
use App\Services\UserCatalogueService;
use Illuminate\Http\Request;

class UserCatalogueController extends Controller
{
    protected $userCatalogueService;
    protected $userCatalogueRepository;

    public function __constructor(UserCatalogueService $userCatalogueService,UserCatalogueRepository $userCatalogueRepository)
    {
        $this->userCatalogueService = $userCatalogueService;
        $this->userCatalogueRepository = $userCatalogueRepository;
    }

    public function index(Request $request)
    {
        $userCatalogues = $this->userCatalogueService->paginate($request);


        return view('backend.users.index', compact('users'));
    }

    public function create()
    {


        return view('backedn.users.create', compact('location'));
    }

    public function store(StoreUserCatalogueRequest $request)
    {
        if ($this->userCatalogueService->create($request)) {
            return redirect()->route('users.index')->with('success', 'Create new member successfully!');
        }

        return redirect()->back()->with('error', 'Something went wrong!');
    }

    public function edit($id)
    {
        $user = $this->userCatalogueRepository->findById($id);


        return view('backend.users.edit', compact('user', 'province'));
    }

    public function update($id, UpdateUserRequest $request)
    {
        if ($this->userCatalogueService->update($id,$request)) {
            return redirect()->route('users.update')->with('success', 'Update member successfully!');
        }

        return redirect()->back()->with('error', 'Something went wrong!');
    }

    public function delete($id)
    {
       $user = $this->userCatalogueRepository->findById($id);
       return view('backend.users.delete', compact('user'));
    }

    public function destroy($id)
    {
        if ($this->userCatalogueService->delete($id)) {
            return redirect()->route('users.delete')->with('success', 'Delete successfully!');
        }

        return redirect()->back()->with('error', 'Something went wrong!');

    }
}
