<?php

namespace App\Http\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FlutterAddOrderResquest extends FormRequest
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
            'totalPrice'=>['required','integer'],
            'date'=>['required','string'],
            'labId'=>['required','integer'],
            'instructios'=>['required','string'],
            'contactId'=>['required','integer'],
            'lines.*.dateStart'=>['string','required'],
            'lines.*.analysis'=>['required','string'],
            'lines.*.price'=>['required','integer'],
        ];
    }

    public function messages()
    {
        return [
            'rate.required'=>"رأيك مطلوب"
        ];
    }

     function failedValidation($validator)
    {
        $errors = $validator->errors();
        $response = Controller::sendError(['result'=>$errors->messages()],'invald data input',422);
        throw new HttpResponseException($response);
    }
}
