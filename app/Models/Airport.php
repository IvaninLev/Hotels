<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class   Airport extends Model
{
    use CrudTrait;

    public $timestamps = false;
    protected $fillable = [
      'name',
      'city_id'
    ];

    public function city():BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
