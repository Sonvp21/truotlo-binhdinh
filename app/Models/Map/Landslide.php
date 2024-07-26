<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Facades\Storage;

class Landslide extends Model
{
    protected $table = 'landslide';

    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class);
    }

    public function district(): HasOneThrough
    {
        return $this->hasOneThrough(District::class, Commune::class, 'id', 'id', 'commune_id', 'district_id');
    }

    public function images(): Attribute
    {
        return Attribute::make(
            get: fn () => Storage::disk('public')->files('images/landslides/'.$this->id)
        );
    }
}
