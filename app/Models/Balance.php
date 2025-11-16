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
 * @property int $user_id
 * @property float $amount
 * @property float $balance
 * @property string $comment
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Balance extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $casts = [
        'amount' => 'float',
        'balance' => 'float',
    ];

    protected $fillable = [
        'user_id',
        'amount',
        'balance',
        'status',
        'comment'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
