<?php

namespace App\Models;

/**
 * @property string lang
 * @property string title
 * @property string content
 * @property int weight
 * @property int is_open
 */
class Notice extends Model
{
    protected $casts = [
        'weight' => 'integer',
        'is_open' => 'integer',
    ];
}
