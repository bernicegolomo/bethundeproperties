<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property_Flats extends Model
{
    protected $table = 'property_flats';
    use HasFactory;

    protected $fillable = [
        'property_id',
        'flatno',
        'description',
        'status',
    ];
}
