<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_category_event',
        'id_research_area',
        'title',
        'short_title',
        'description',
        'event_foto',
    ];
}
