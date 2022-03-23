<?php

namespace App\Http\Requests;

use App\Http\Controllers\V1\BaseController;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {

        $errors = $validator->errors();

        $data   = [];
        foreach ($errors->messages() as $item) {
            array_push($data, $item[0]);
        }

        throw new HttpResponseException((new BaseController())->returnFalse('failed', $data));
    }
}
