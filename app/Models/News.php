<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Pagination\LengthAwarePaginator;

class News extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['type'];

    public static function Recs(array $filters = [], int $perPage = 5): LengthAwarePaginator
    {
        return self::filter($filters)->paginate($perPage);
//        return self::with(['type'])->cursorPaginate($perPage);
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when($filters['type'] ?? false,
            fn($query, $type) => $query->whereExists(
                fn($query) => $query
                    ->from("news_types")
                    ->whereColumn("news_types.id", "type_id")
                    ->where("token", $type)
            )
        );
    }


    public function type(): BelongsTo
    {
        return $this->belongsTo(NewsType::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
