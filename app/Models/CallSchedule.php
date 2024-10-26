<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallSchedule extends Model
{
    use HasFactory;
    protected $fillable = ['scheduled_date', 'scheduled_time', 'status'];
}
