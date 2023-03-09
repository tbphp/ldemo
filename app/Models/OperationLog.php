<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int admin_id
 * @property string ip
 * @property int type
 * @property string before_data
 * @property string after_data
 * @property string loggable_type
 * @property int loggable_id
 * @property string note
 */
class OperationLog extends Model
{
    protected $casts = [
        'admin_id' => 'integer',
        'type' => 'integer',
    ];

    protected $hidden = [
        'admin_id',
        'loggable_id',
        'loggable_type',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function loggable(): MorphTo
    {
        return $this->morphTo();
    }
}
