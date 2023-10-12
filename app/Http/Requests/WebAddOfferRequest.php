<?php

namespace App\Http\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class WebAddOfferRequest extends FormRequest
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
                'dateEnd'=>['date_format:Y-m-d','required'],
                'photo'=>['image','mimes:jpeg,jpg,png,gif'],
                'priceBeforOffer'=>['integer','required'],
                'priceAfterOffer'=>['integer','required'],
                'analysisCount'=>['integer','required'],
                'analysisIds.*'=>['integer','required'],
        ];
    }

    public function messages()
    {
        return [
            'date.required'=>"التاريخ مطلوب"
        ];
    }

     function failedValidation($validator)
    {
        $errors = $validator->errors();
        $response = Controller::sendError(['result'=>$errors->messages()],'invald data input',422);
        throw new HttpResponseException($response);
    }
}
