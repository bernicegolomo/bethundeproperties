<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rents extends Model
{
    use HasFactory;
    protected $fillable = [
        'property_id',
        'flat_id',
        'tenant_id',
        'fee',
        'start_year',
        'end_year',
        'status',
    ];
}
