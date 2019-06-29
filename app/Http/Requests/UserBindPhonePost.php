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
            'verify_code' => 'required|size:5'
        ];
    }
}
