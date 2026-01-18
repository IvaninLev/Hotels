<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string', 'required'],
            'description' => ['string', 'required'],
            'country' => ['required', 'exists:countries,id'],
            'city' => ['required', 'exists:cities,id'],
            'images' => ['required', 'array'],
            'roomTypes' => ['required','    json', 'min:1'],
            'roomTypes.*' => ['array'],
            'roomTypes.*.room_type_id' => ['required', 'int', 'exists:room_types,id'],
            'roomTypes.*.beds' => ['required', 'int'],
            'roomTypes.*.area' => ['required', 'decimal'],
            'roomTypes.*.price' => ['required', 'decimal'],
            'roomTypes.*.total_rooms' => ['required', 'int']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
