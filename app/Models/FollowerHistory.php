<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class FollowerHistory extends Model
{
    /** @use HasFactory<\Database\Factories\FollowerHistoryFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function followable(): MorphTo
    {
        return $this->morphTo();
    }
}
