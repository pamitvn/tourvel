<?php

namespace App\Models\Tour;

use App\Models\Tour;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TourCategory extends Model
{
    protected $fillable = [
        'name'
    ];

    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class, 'category_id', 'id');
    }
}
