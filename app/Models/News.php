<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    public $timestamps = false;

    protected $table = 'news';
    protected $fillable = [
        'title',
        'text',
        'image',
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'image' => 'array',
    ];
}
