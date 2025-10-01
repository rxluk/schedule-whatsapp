<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnavailableDays extends Model
{
    use HasFactory;

    protected $table = 'unavailable_days';

    protected $fillable = [
        'user_id',
        'unavailable_date',
        'start_time',
        'end_time',
        'reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
