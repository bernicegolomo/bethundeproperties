<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenants extends Model
{
    use HasFactory;
    protected $fillable = [
        'firstname',
        'lastname',
        'phone',
        'occupation',
        'email',
        'previous_address',
        'guarantor_name',
        'guarantor_phone',            
        'guarantor_address',
        'property_id',
        'flat_id',
	'fee',
        'startdate',
        'rent_due_date',
        'left_date',
        'status',
    ];
}
