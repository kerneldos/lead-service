<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $channel_id
 * @property array $data
 * @property bool $is_full
 * @property Carbon $processed_at
 * @property Carbon $created_at
 */
class LeadModel extends Model
{
    protected $table = 'leads';
    protected $fillable = [
        'channel_id', 'data', 'is_full', 'processed_at'
    ];
    protected $casts = [
        'data' => 'array',
        'is_full' => 'boolean',
        'processed_at' => 'datetime'
    ];
}
