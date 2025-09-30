<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    use HasFactory;
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'professional_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'full_name',
        'display_name',
        'whatsapp_number',
        'email',
        'company_description',
        'working_days',
        'work_start_time',
        'work_end_time',
        'account_status',
        'plan',
    ];
    
    /**
     * Get the user that owns the professional.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    
    /**
     * Get the services for the professional.
     */
    public function services()
    {
        return $this->hasMany(Service::class, 'professional_id', 'professional_id');
    }
    
    /**
     * Get the appointments for the professional.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'professional_id', 'professional_id');
    }
    
    /**
     * Get the unavailable times for the professional.
     */
    public function unavailableTimes()
    {
        return $this->hasMany(UnavailableTime::class, 'professional_id', 'professional_id');
    }
    
    /**
     * Get the bot configuration for the professional.
     */
    public function botConfiguration()
    {
        return $this->hasOne(BotConfiguration::class, 'professional_id', 'professional_id');
    }
    
    /**
     * Get the conversation sessions for the professional.
     */
    public function conversationSessions()
    {
        return $this->hasMany(ConversationSession::class, 'professional_id', 'professional_id');
    }
}
