<?php

namespace App\Services;

use App\Repositories\Interfaces\UserCatalogueRepositoryInterface as UserCatalogueRepository;
use App\Services\Interfaces\UserCatalogueServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;


/**
 * Class UserService
 * @package App\Services
 */
class UserCatalogueService implements UserCatalogueServiceInterface
{
    protected $userCatalogueRepository;

    public function __construct(UserCatalogueRepository $userCatalogueRepository)
    {
        $this->userCatalogueRepository = $userCatalogueRepository;
    }

    private function paginateSelect()
    {
        return ['id', 'name', 'phone', 'email', 'address', 'publish'];
    }

    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->integer('publish');
        $perPage = $request->integer('perpage');
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
            $user = $this->userRepository->update($post['modelId'],$payload);

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
