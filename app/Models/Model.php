<?php
/**
 * 公共模型
 */

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model as Eloquent;

abstract class Model extends Eloquent
{
    use ModelAnnotate;

    protected $dateFormat = 'U';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $perPage = 10;

    protected $hidden = [
        'password',
    ];

    protected function serializeDate(DateTimeInterface $date): int
    {
        return $date->getTimestamp();
    }
}
