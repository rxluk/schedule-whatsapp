<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnavailableTime extends Model
{
    use HasFactory;
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'block_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'professional_id',
        'block_date',
        'start_time',
        'end_time',
        'reason',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'block_date' => 'date',
    ];
    
    /**
     * Get the professional that owns the unavailable time.
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class, 'professional_id', 'professional_id');
    }
}
