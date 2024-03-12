<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserCatalogueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|string|unique:users,email, '.$this->id.'|max:191',
            'fullname' => 'required|string',
            'user_catalogue_id' => 'required|interger|gt:0',

        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Email đã tồn tại',
            'email.required' => 'Email không được để trống',
            'password.required' => 'Mật khẩu không được để trống',
            'fullname.required' => 'Họ tên không được để trống',
            'user_catalogue_id.required' => 'Vui lòng chọn vai trò',
            'user_catalogue_id.gt' => 'Bạn chưa chọn vai trò'
        ];
    }
}
