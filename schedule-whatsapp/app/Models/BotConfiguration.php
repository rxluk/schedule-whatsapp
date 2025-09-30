<?php

namespace App\Models;

use App\Bot\Menu\Menu;
use App\Bot\Menu\MenuFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotConfiguration extends Model
{
    use HasFactory;
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'config_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'professional_id',
        'welcome_message',
        'bot_menu_structure_json',
        'appointment_success_message',
        'appointment_canceled_message',
        'no_available_times_message',
        'payment_info_text',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'bot_menu_structure_json' => 'array',
    ];
    
    /**
     * Get the professional that owns the bot configuration.
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class, 'professional_id', 'professional_id');
    }
    
    /**
     *
     * @return Menu
     */
    public function getMenuStructure(): Menu
    {
        if (empty($this->bot_menu_structure_json)) {
            return MenuFactory::createDefaultMenu();
        }
        
        return MenuFactory::createFromData($this->bot_menu_structure_json);
    }
    
    /**
     *
     * @param Menu
     * @return self
     */
    public function setMenuStructure(Menu $menu): self
    {
        $this->bot_menu_structure_json = $menu->toArray();
        return $this;
    }
}
