<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    protected $table = 'counters';

    public $timestamps = false;

    protected $dates = ['date'];

    protected $fillable = ['ip', 'user_agent', 'time', 'date'];
}
