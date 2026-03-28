<?php

namespace App\Http\Resources;

use App\Models\Nutrition;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Nutrition */

class NutritionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'code' => $this->code,
        ];
    }
}
