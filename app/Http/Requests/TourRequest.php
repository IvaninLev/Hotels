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
            'base_price' => ['required', 'decimal:10,2'],
            'images' => ['required', 'json'],
            'hotel_id' => ['required', 'integer', 'exists:hotels,id'],
            'active_from' => ['required', 'date'],
            'active_to' => ['required', 'date'],
            'tour_departure' => ['required', 'integer', 'exists:tour_departures,id'],
            'dates' => ['required', 'date'],
            'country_id' => ['required', 'exists:countries,id'],
            'city_id' => ['required', 'exists:cities,id'],


        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
