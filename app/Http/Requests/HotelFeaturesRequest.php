<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelFeaturesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'hotel_id' => ['required', 'integer', 'exists:hotels,id'],
            'name' => ['required', 'string'],
            'category' => ['required', 'string'],
            'value' => ['required', 'string'],
        ];

    }
}
