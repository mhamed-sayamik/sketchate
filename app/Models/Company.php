<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'contact_address',
        'contact_email',
        'contact_phone',
        'contact_website',
        'company_file',
        'province_id',
        'category_id',
        'user_id'
    ];

    public function projects():BelongsToMany{
        return $this->belongsToMany(Project::class, 'offers')->as('offer')->withPivot('contract_file', 'is_accurate', 'value');
    }
    public function category():BelongsTo{
        return $this->belongsTo(Category::class);
    }
    public function province(): BelongsTo{
        return $this->belongsTo(Province::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
