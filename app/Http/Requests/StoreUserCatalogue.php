<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserCatalogueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|string|unique:users,email',
            'fullname' => 'required|string',
            'user_catalogue_id' => 'required|interger|gt:0',
            'password' => 'required|string|min:6',
            're_password' => 'required|same:password',
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
            'user_catalogue_id.gt' => 'Bạn chưa chọn vai trò',
            're_password.required' => 'Mật khẩu nhập lại không được để trống',
            're_password.same' => 'Mật khẩu nhập lại không đúng',
        ];
    }
}
