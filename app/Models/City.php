<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    use CrudTrait;

    public $timestamps = false;
    protected $fillable=[
      'name',
      'country_id',
      'external_id'
    ];

    public function country():BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
