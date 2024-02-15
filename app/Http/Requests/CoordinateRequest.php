<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CoordinateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'latitude' => ['required', 'regex:/([0-9.-]+).+?([0-9.-]+)/u'],
            'longitude' => ['required', 'regex:/([0-9.-]+).+?([0-9.-]+)/u']
        ];
    }
}
