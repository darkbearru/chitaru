<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function type (): BelongsTo
    {
        return $this->belongsTo(NewsType::class);
    }

    public function region () : BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function category () : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
