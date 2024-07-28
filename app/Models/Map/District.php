<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';

    public function communes()
    {
        return $this->hasMany(Commune::class);
    }
}
