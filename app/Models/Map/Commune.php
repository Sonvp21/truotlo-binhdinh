<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commune extends Model
{
    protected $table = 'map_communes';

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
