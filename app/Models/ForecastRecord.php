<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForecastRecord extends Model
{
    use HasFactory;
    protected $fillable = ['nam', 'thang', 'ngay', 'gio'];

    public function points()
    {
        return $this->hasMany(ForecastRecordPoint::class, 'record_id');
    }
}
