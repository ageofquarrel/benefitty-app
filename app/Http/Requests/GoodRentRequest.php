<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoodRentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id'       => 'required|integer|exists:users,id',
            'good_id'       => 'required|integer|exists:goods,id',
            'rent_hours'    => 'required|integer'
        ];
    }
}
