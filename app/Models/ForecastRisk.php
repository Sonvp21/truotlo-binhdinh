<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForecastRisk extends Model
{
    use HasFactory;
    protected $fillable = ['point_id', 'ngay', 'nguy_co'];

    public function point()
    {
        return $this->belongsTo(ForecastPoint::class, 'point_id');
    }
}
