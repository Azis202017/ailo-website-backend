<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'event_foto_categories'
    ];
    public function event() {
        return $this->hasMany(Event::class, 'id_category_event');
    }
}
