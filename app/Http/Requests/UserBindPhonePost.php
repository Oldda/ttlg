<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserBindPhonePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => 'required|size:11|unique:user',
            'verify_code' => 'required|size:6'
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => '手机号不能为空！',
            'phone.size' => '手机号格式不正确！',
            'phone.unique' => '手机号已被占用！',
            'verify_code.required' => '验证码不能为空！',
            'verify_size' => '验证码错误！'
        ];
    }
}
