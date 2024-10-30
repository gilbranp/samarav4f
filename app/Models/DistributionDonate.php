<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DistributionDonate extends Model
{
    protected $table = 'distribution_donates';
    protected $guarded = [];

    public function penerima(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penerima_id', 'id');
    }
}
