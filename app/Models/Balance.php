<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Balance.
 *
 * @property int $id
 * @property int $iser_id
 * @property float $amount
 * @property float $balance
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Balance extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $casts = [
        'date' => 'date',
        'entity_id' => 'integer',
        'all_views_count' => 'integer',
        'unique_views_count' => 'integer',
        'all_clicks_count' => 'integer',
        'unique_clicks_count' => 'integer',
        'unique_phones_count' => 'integer',
        'amount' => 'float',
        'balance' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
