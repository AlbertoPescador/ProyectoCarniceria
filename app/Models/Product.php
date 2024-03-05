<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function lines()
    {
        return $this->hasMany(Line::class);
    }

    public function categorys()
    {
        return $this->HasMany(Category::class);
    }
}
