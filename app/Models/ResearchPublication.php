<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchPublication extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_research_area',
        'title',
        'description',
        'publish_year',
        'link_publication'
    ];
    public function research_area() {
        return $this->belongsTo(ResearchArea::class, 'id_research_area');
    }

}
