<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TourRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'decimal:0'],
            'hotel_id' => ['required', 'integer',],
            'airport_id' => ['required', 'integer', ],
            'active_from' => ['required', 'date'],
            'active_to' => ['required', 'date']


        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
