<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use CrudTrait;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'iso_code'
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}
