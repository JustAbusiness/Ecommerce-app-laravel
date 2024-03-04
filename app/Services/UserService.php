<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\Cast\Object_;

/**
 * Class UserService
 * @package App\Services
 */
class UserService implements UserServiceInterface
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    private function paginateSelect()
    {
        return ['id', 'name', 'phone', 'email', 'address', 'publish'];
    }

    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $perPage = $request->integer('prepare');

        $users = $this->userRepository->pagination($this->paginateSelect(), $condition, [], [
            'path' => 'user.index'
        ], $perPage);

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
        } catch (\Exception $e) {
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

            $user = $this->userRepository->update($id, $payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }


    private function convertBirthDate($birthday = '')
    {
        $carbonDate = Carbon::createFromFormat(
            'Y-m-d',
            $birthday
        );
        $birthday = $carbonDate->format('Y-m-d H:i:s');

        return $birthday;
    }


    public function updateStatus($post = [])
    {
        DB::beginTransaction();
        try {
            $payload[$post['field']] = (($post['value'] == 1) ? 0 : 1);
            $user = $this->userRepository->update($post['modelId'], $payload);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }


    public function updateStatusAll($post)
    {
        DB::beginTransaction();
        try {
            $payload[$post['field']] = ($post['value'] );
            $user = $this->userRepository->updateByWhereIn('id', $post['id'], $payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->forceDelete($id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
