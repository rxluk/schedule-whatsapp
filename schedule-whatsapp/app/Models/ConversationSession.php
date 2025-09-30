<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversationSession extends Model
{
    use HasFactory;
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'session_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'professional_id',
        'current_state',
        'context_data',
        'last_message_at',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'context_data' => 'array',
        'last_message_at' => 'datetime',
    ];
    
    /**
     * Get the professional associated with the conversation session.
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class, 'professional_id', 'professional_id');
    }
    
    /**
     * Get the client associated with the conversation session.
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }
}
