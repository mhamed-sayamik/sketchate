<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    use HasFactory;
    protected $fillable = ['name',
    'description',
    'total_area',
    'floor',
    'support_omanian_firms',
];
}
