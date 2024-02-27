<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService
 * @package App\Services
 */
class UserService implements UserServiceInterface
{
    protected $userRepository;

    public function __construct( UserRepository $userRepository )
    {
        $this->userRepository = $userRepository;
    }

    public function paginate()
    {
        $users = $this->userRepository->pagination(['id', 'name', 'phone'
        ,'email', 'address', 'publish' ]);
        return $users;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->except(['_token', 'send', 're_password']);
            $payload['birthday'] = $this->convertBirthDate($payload['birthday']);
            $payload['password'] = Hash::make($payload['password']);

            $user = $this->userRepository->create($payload);

            DB::commit();
            return true;
        }catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
    public function update($request, $id)
    {
        DB::beginTransaction();
        try {

            $payload = $request->except(['_token', 'send']);
            $payload['birthday'] = $this->convertBirthDate($payload['birthday']);
            $payload['password'] = Hash::make($payload['password']);

            $user = $this->userRepository->update($id,$payload);
            DB::commit();
            return true;
        }catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }


    private function convertBirthDate($birthday = '')
    {
        $carbonDate = Carbon::createFromFormat(
            'Y-m-d', $birthday);
        $birthday = $carbonDate->format('Y-m-d H:i:s');

        return $birthday;
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $user =$this->userRepository->forceDelete($id);
            DB::commit();
            return true;
        }catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
