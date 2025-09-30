<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'client_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'whatsapp_number',
    ];
    
    /**
     * Get the appointments for the client.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'client_id', 'client_id');
    }
    
    /**
     * Get the conversation sessions for the client.
     */
    public function conversationSessions()
    {
        return $this->hasMany(ConversationSession::class, 'client_id', 'client_id');
    }
}
