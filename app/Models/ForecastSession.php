<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForecastSession extends Model
{
    use HasFactory;
    protected $fillable = ['nam', 'thang'];

    public function points()
    {
        return $this->hasMany(ForecastPoint::class, 'session_id');
    }
}
