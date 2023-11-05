<?php

namespace app\Models;

use App\Models\Project;
use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'province_id',
        'user_id'
    ];
    public function province(): BelongsTo{
        return $this->belongsTo(Province::class);
    }
    public function projects(): HasMany{
        return $this->hasMany(Project::class, 'user_id');
    }
}
