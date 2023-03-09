<?php

namespace App\Models;

/**
 * @property int version
 * @property string lang
 * @property string title
 * @property string content
 * @property int is_force
 * @property int is_open
 */
class PopUp extends Model
{
    protected $casts = [
        'version' => 'integer',
        'is_force' => 'integer',
        'is_open' => 'integer',
    ];
}
