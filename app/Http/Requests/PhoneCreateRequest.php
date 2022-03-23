<?php

namespace App\Http\Requests;

class PhoneCreateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone_number' => 'required|unique:phones,phone_number',
            'provider'     => 'required',
        ];
    }
}
