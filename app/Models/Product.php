<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'country',
        'city',
        'district',
        'surface_area',
        'image',
        'no_rooms',
        'no_bedrooms',
        'no_bathrooms',
        'no_garages',
        'type',
        'status',
    ];

    protected $casts = [
        'image' => 'array',
    ];
}
