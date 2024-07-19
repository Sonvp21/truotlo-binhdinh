<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForecastPoint extends Model
{
    use HasFactory;
    protected $fillable = ['session_id', 'ten_diem', 'vi_tri', 'kinh_do', 'vi_do', 'tinh', 'huyen', 'xa'];

    public function session()
    {
        return $this->belongsTo(ForecastRecord::class, 'session_id');
    }

    public function risks()
    {
        return $this->hasMany(ForecastRisk::class, 'point_id');
    }
}
