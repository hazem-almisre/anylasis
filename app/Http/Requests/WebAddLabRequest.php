<?php

namespace App\Http\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class WebAddLabRequest extends FormRequest
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
                'phone'=>['string','required','min:10','max:10'],
                'phoneEnter'=>['string','required','unique:labs,phoneEnter'],
                'name'=>['string','required','max:255'],
                'ownerName'=>['string','required','max:255'],
                'password'=>['string','required','min:8'],
                'address'=>['string','required'],
                'labLocationId'=>['integer','required'],
                'photo'=>['required','image','mimes:jpeg,jpg,png,gif'],
                // 'isActive'=>['boolean'],
                'region'=>['string','required'],
                'description'=>['required','string']
        ];
    }

    public function messages()
    {
        return [
            'phone.required'=>"الهاتف مطلوب",
            'phone.min'=>"الرقم يجب ان يتألف من عشر خانات",
        ];
    }

     function failedValidation($validator)
    {
        $errors = $validator->errors();
        $response = Controller::sendError(['result'=>$errors->messages()],'invald data input',422);
        throw new HttpResponseException($response);
    }
}
