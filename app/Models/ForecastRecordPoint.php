<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForecastRecordPoint extends Model
{
    use HasFactory;
    protected $fillable = ['record_id', 'ten_diem', 'vi_tri', 'kinh_do', 'vi_do', 'tinh', 'huyen', 'xa', 'nguy_co'];

    public function record()
    {
        return $this->belongsTo(ForecastRecord::class, 'record_id');
    }
}
