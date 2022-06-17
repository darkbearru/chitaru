<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function Latest(): Collection
    {
        return self::DateFormat(self::with(['type'])->get());
//        return self::with(['type', 'region', 'category'])->paginate(10);
    }

    protected static function DateFormat(Collection $list): Collection
    {
        foreach ($list as $item) {
            $item->published_at =
                Carbon::createFromFormat('Y-m-d H:i:s', $item->published_at)
                    ->locale('ru')
                    ->isoFormat('Do MMMM, HH:mm');
        }
        return $list;
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
