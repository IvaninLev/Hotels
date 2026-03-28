<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TourDepartureRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tour_id' => ['required', 'exists:tour,id'],
            'price' => ['required', 'decimal:2'],
            'duration' => ['required', 'integer', 'min:3'],
            'airport_id' => ['required', 'exists:airport,id'],
            'departure_date' => ['required', 'date'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
