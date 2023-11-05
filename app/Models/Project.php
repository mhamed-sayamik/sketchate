<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['milkyah_file',
    'krooky_file' ,
    'owner_id_file',
    'deadline',
    'support_omanian_firms',
    'price_range_id',
    "user_id",
    "aprox-area"
];

    public function categories(){
        return $this->belongsToMany(Category::class, 'project_company_categories');
    }
    public function spaces(){
        return $this->hasMany(Space::class);
    }
    public function price_range(){
        return $this->belongsTo(PriceRange::class);
    }
    public function companies():BelongsToMany{
        return $this->belongsToMany(Company::class, 'offers')->as('offer')->withPivot('contract_file', 'is_accurate', 'value');;
    }
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function theWinnerCompany(){
        return $this->belongsTo(Company::class,'winner_company');
    }


}
