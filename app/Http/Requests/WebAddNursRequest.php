<?php

namespace App\Http\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class WebAddNursRequest extends FormRequest
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
                'phone'=>['string','required','unique:nurses,phone'],
                'name'=>['string','required','max:255'],
                'password'=>['string','required','min:8'],
                'address'=>['string','required'],
                'photo'=>['nullable','image','mimes:jpeg,jpg,png,gif'],
                // 'isActive'=>['boolean'],
                'ratio'=>['integer','required'],
                'labLocationIds.*'=>['integer','nullable'],
        ];
    }

    public function messages()
    {
        return [
            'phone.required'=>"الهاتف مطلوب"
        ];
    }

     function failedValidation($validator)
    {
        $errors = $validator->errors();
        $response = Controller::sendError(['result'=>$errors->messages()],'invald data input',422);
        throw new HttpResponseException($response);
    }
}
