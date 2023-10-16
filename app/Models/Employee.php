<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
        'number',
        'department',
        'role',
        'profile_image',
        'division_id'
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

}
